<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Booking\BookingWebRequest;
use App\Http\Requests\Booking\FEbookingRequest;
use App\Http\Requests\Customer\CustomerRequest;
use App\Mail\BookingMail;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Enums\BookingStatusEnum;
use App\Models\Enums\MethodPaymentEnum;
use App\Models\Enums\PaymentStatusEnum;
use App\Models\Enums\RoomStatusEnum;
use App\Models\Enums\TypeBookingEnum;
use App\Repositories\Eloquent\BookingFoodRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\BookingRoomRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\FoodRepository;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\BookingFoodService;
use App\Services\BookingRoomService;
use App\Services\BookingService;
use App\Services\CustomerService;
use App\Services\RoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Stripe\PaymentIntent;

class BookingController extends FrontendController
{
    protected $repository;
    protected $roomRepository;
    protected $foodRepository;
    protected $bookingRoomRepository;
    protected $bookingFoodRepository;
    protected $customerRepository;
    protected $service;
    protected $customerService;
    protected $roomService;
    protected $bookingRoomService;
    protected $bookingFoodService;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(BookingRepository::class);
        $this->roomRepository = app(RoomRepository::class);
        $this->foodRepository = app(FoodRepository::class);
        $this->bookingRoomRepository = app(BookingRoomRepository::class);
        $this->bookingFoodRepository = app(BookingFoodRepository::class);
        $this->customerRepository = app(CustomerRepository::class);
        $this->service = app(BookingService::class);
        $this->customerService = app(CustomerService::class);
        $this->roomService = app(RoomService::class);
        $this->bookingRoomService = app(BookingRoomService::class);
        $this->bookingFoodService = app(BookingFoodService::class);
    }

    public function filterRoom(BookingWebRequest $request)
    {
        $params = $request->all();
        $data = [
            'time_check_in' => data_get($params, 'time_check_in'),
            'time_check_out' => data_get($params, 'time_check_out'),
            'number_people' => array_filter(data_get($params, 'room')),
        ];

        return Inertia::render('Web/Booking/RoomAvailable', [
            'rooms' => $this->roomRepository->getListFilterRoom($data),
            'info_booking' => [
                'time_check_in' => data_get($params, 'time_check_in'),
                'time_check_out' => data_get($params, 'time_check_out'),
                'time_stay' => timeStay(data_get($params, 'time_check_in'), data_get($params, 'time_check_out'))
            ],
        ]);
    }

    public function bookFood(Request $request)
    {
        $params = $request->all();

        $record = $this->roomRepository->getListSelectRoom(data_get($params, 'rooms'));
        $foods = $this->foodRepository->get();

        return Inertia::render('Web/Booking/BookingFood', [
            'foods' => $foods->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'price' => $value->price,
                    'description' => $value->description,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            'info_booking' => $params,
            'select_rooms' => $record,
        ]);
    }

    public function confirm(Request $request)
    {
        $params = $request->all();

        $rooms = $this->roomRepository->getListSelectRoom(data_get(data_get($params, 'info_booking'), 'rooms'));
        $foods = array_key_exists("select_food", $params) ? $this->foodRepository->getListSelectFood(data_get($params, 'select_food')) : [];

        session()->forget('rooms');
        session()->forget('foods');
        foreach ($rooms as $key => $room) {
            $request->session()->push('rooms', $room['name']);
        }
        foreach ($foods as $key => $food) {
            $request->session()->push('foods', [$food['name'], $food['id']]);
        }

        return Inertia::render('Web/Booking/Confirm', [
            'booking' => $params,
            'select_rooms' => $rooms,
            'select_foods' => $foods,
        ]);
    }

    public function payment(FEbookingRequest $request)
    {
        $params = $request->all();

        return Inertia::render('Web/Booking/Payment', [
            'info_booking' => $params,
            'select_rooms' => session('rooms'),
            'select_foods' => session('foods'),
        ]);
    }

    public function memberPayment(Request $request)
    {
        $params = $request->all();
        $rooms = $this->roomRepository->getListSelectRoom(data_get(data_get($params, 'info_booking'), 'rooms'));
        $foods = array_key_exists("select_food", $params) ? $this->foodRepository->getListSelectFood(data_get($params, 'select_food')) : [];
        $arrayRooms = [];
        $arrayFood = [];

        foreach ($rooms as $key => $room) {
            array_push($arrayRooms, $room['name']);
        }
        foreach ($foods as $key => $food) {
            array_push($arrayFood, [$food['name'], $food['id']]);
        }

        return Inertia::render('Web/Booking/Payment', [
            'info_booking' => ['booking' => $params],
            'select_rooms' => $arrayRooms,
            'select_foods' => $arrayFood,
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $bookings = $this->repository->where('time_check_in', '=', $request['booking']['info_booking']['time_check_in'])
                ->where('time_check_out', '=', $request['booking']['info_booking']['time_check_out'])
                ->where('number_rooms', '=', count($request['booking']['info_booking']['rooms']))->with('bookingRoom')->get();

            $newBooking = $request['booking']['info_booking']['rooms'];
            foreach ($bookings as $booking) {
                $bookingInDb = $booking->bookingRoom->pluck('room_id')->toArray();

                if(count(array_diff($bookingInDb, $newBooking)) === 0 && count(array_diff($newBooking, $bookingInDb)) === 0){
                    if (array_key_exists("payment_method_id", $params)){
                        return response()->json(['message' => getConstant('messages.PAYMENT_FAIL')], 500);
                    }

                    return back()->with(['toast' => ['action_failed' => getConstant('messages.PAYMENT_FAIL')]]);
                }
            }

            $customer = $this->customerRepository->firstOrCreate(
                [
                    'email' => $request['email'],
                ],
                [
                    'name' => $request['name'],
                    'address' => $request['address'],
                    'gender' => $request['gender'],
                    'phone' => $request['phone'],
                    'identity_card' => $request['identity_card'],
                    'password' => Hash::make($request['password']),
                ]
            );

            if (!$customer) {
                DB::rollback();

                return back()->with(['toast' => ['action_failed' => getConstant('messages.PAYMENT_FAIL')]]);
            }

            // booking
            $dataBooking = [
                'customer_id' => $customer->id,
                'type_booking' => TypeBookingEnum::ONLINE->value,
                'time_check_in' => $request['booking']['info_booking']['time_check_in'],
                'time_check_out' => $request['booking']['info_booking']['time_check_out'],
                'number_rooms' => count($request['booking']['info_booking']['rooms']),
                'status_booking' => BookingStatusEnum::EXPECTED_ARRIVAL->value,
                'status_payment' => PaymentStatusEnum::UNPAID->value,
                'method_payment' => MethodPaymentEnum::CASH->value,
            ];

            $booking = $this->repository->create($dataBooking);
            if (!$booking) {
                DB::rollback();

                return back()->with(['toast' => ['action_failed' => getConstant('messages.PAYMENT_FAIL')]]);
            }

            //booking rooms
            if (!empty($request['booking']['info_booking']['rooms'])) {
                foreach ($request['booking']['info_booking']['rooms'] as $key => $value) {
                    $dataRoom['booking_id'] = $booking->id;
                    $dataRoom['room_id'] = $value;
                    $dataRoom['price'] = $request['booking']['info_booking']['price_each_room'][$key];

                    $room = $this->roomRepository->find($value);
                    $dataRoom['number_people'] = $room->number_people;

                    if (!$this->bookingRoomService->store($dataRoom)) {
                        DB::rollback();

                        return back()->with(['toast' => ['action_failed' => getConstant('messages.PAYMENT_FAIL')]]);
                    }

                    // thông tin để gửi mail
                    $bookRoom[$key] = [
                        'room_name' => $room->name,
                        'price' => $request['booking']['info_booking']['price_each_room'][$key],
                        'number_people' => $room->number_people,
                    ];
                }
            }

            $bookFood = [];
            //booking foods
            if (!empty($request['booking']['select_food'])) {
                foreach ($request['booking']['select_food'] as $key => $value) {
                    if (!is_null($value)) {
                        $dataFood['amount'] = $value;
                        $dataFood['price'] = $request['booking']['price_food'][$key];
                        $dataFood['food_id'] = $key;
                        $dataFood['booking_id'] = $booking->id;

                        array_push($bookFood, data_get($this->foodRepository->find($key), 'name'));
                        if (!$this->bookingFoodService->store($dataFood)) {
                            DB::rollback();

                            return back()->with(['toast' => ['action_failed' => getConstant('messages.PAYMENT_FAIL')]]);
                        }
                    }
                }
            }

            if (array_key_exists("payment_method_id", $params)) {
                $payment = $customer->charge(
                    $request['amount'],
                    $request['payment_method_id'],
                    $options = [
                        'metadata' => [
                            'booking_id' => $booking->id,
                        ]
                    ],
                );
                $paymentIntent = $payment->asStripePaymentIntent();
            }

            // gửi mail
            $dataMail = [
                'time_check_in' => $request['booking']['info_booking']['time_check_in'],
                'time_check_out' => $request['booking']['info_booking']['time_check_out'],
                'room' => $bookRoom,
                'food' => $bookFood,
            ];

            Mail::to($request['email'])->send(new BookingMail($dataMail));
            DB::commit();
            return to_route('web.booking.complete');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function webhook()
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'charge.succeeded':
                $paymentIntent = $event->data->object;
                $metadata = $paymentIntent->metadata;
                $dataPayment = [
                    'payment_date' => date('Y-m-d H:i:s'),
                    'method_payment' => MethodPaymentEnum::BANKING->value,
                    'status_payment' => PaymentStatusEnum::PAID->value,
                    'total_money' => $paymentIntent->amount,
                ];
                $booking = $this->repository->update($metadata['booking_id'], $dataPayment);

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    public function complete()
    {
        session()->forget('rooms');
        session()->forget('foods');
        return Inertia::render('Web/Booking/Complete');
    }

    public function show(){
        $customer = $this->customerRepository->find(auth('web')->user()->id);
        $bookingCheckIn = $this->repository->where('customer_id',$customer->id)->where('status_booking', BookingStatusEnum::CHECK_IN->value)->with(['bookingRoom.room','bookingFood.food'])->get();
        $bookingCheckOut= $this->repository->where('customer_id',$customer->id)->where('status_booking', BookingStatusEnum::CHECK_OUT->value)->with(['bookingRoom.room','bookingFood.food'])->get();
        $bookingCheckEA = $this->repository->where('customer_id',$customer->id)->where('status_booking', BookingStatusEnum::EXPECTED_ARRIVAL->value)->with(['bookingRoom.room','bookingFood.food'])->get();

        return Inertia::render('Web/Booking/Show', [
            'bookingCheckIn' => $bookingCheckIn,
            'bookingCheckOut' => $bookingCheckOut,
            'bookingCheckEA' => $bookingCheckEA,
            'customer' => $customer,
        ]);
    }
}
