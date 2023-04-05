<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Booking\FEbookingRequest;
use App\Http\Requests\Customer\CustomerRequest;
use App\Models\Booking;
use App\Models\Customer;
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
use Illuminate\Support\Facades\Log;
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

    public function index()
    {
//        return Inertia::render('Web/Home/Index');
    }

    public function create()
    {

    }

    public function filterRoom(Request $request)
    {
        $params = $request->all();
        $data = [
            'time_check_in' => data_get($params, 'time_check_in'),
            'time_check_out' => data_get($params, 'time_check_out'),
            'number_people' => data_get($params, 'room'),
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

    public function store(Request $request)
    {
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
            ]
        );

        try {
            // booking
            $dataBooking = [
                'customer_id' => $customer->id,
                'type_booking' => 1,
                'time_check_in' => $request['booking']['info_booking']['time_check_in'],
                'time_check_out' => $request['booking']['info_booking']['time_check_out'],
                'number_rooms' => count($request['booking']['info_booking']['rooms']),
//                'payment_date' => date('Y-m-d H:i:s'),
//                'method_payment' => 1,
//                'status_payment' => 1,
                'status_booking' => 2,
//                'total_money' => $request['amount'],
            ];
            $booking = $this->repository->create($dataBooking);

            //booking rooms
            if (!empty($request['booking']['info_booking']['rooms'])) {
                foreach ($request['booking']['info_booking']['rooms'] as $key => $value) {
                    $dataRoom['booking_id'] = $booking->id;
                    $dataRoom['room_id'] = $value;
                    $dataRoom['price'] = $request['booking']['info_booking']['price_each_room'][$key];

                    $room = $this->roomRepository->find($value);
                    $dataRoom['number_people'] = $room->number_people;

                    $this->bookingRoomService->store($dataRoom);

                    if (!empty($room)) {
                        $room->status = \App\Models\Enums\RoomStatusEnum::OCCUPIED->value;
                        $room->save();
                    }
                }
            }

            //booking foods
            if (!empty($request['booking']['select_food'])) {
                foreach ($request['booking']['select_food'] as $key => $value) {
                    $dataFood['amount'] = $value;
                    $dataFood['price'] = $request['booking']['price_food'][$key];
                    $dataFood['food_id'] = $key;
                    $dataFood['booking_id'] = $booking->id;

                    $this->bookingFoodService->store($dataFood);
                }
            }

            $payment = $customer->charge(
                $request['amount'],
                $request['payment_method_id'],
            );
            $paymentIntent = $payment->asStripePaymentIntent();

//            $paymentIntent = $payment->asStripePaymentIntent();
//            $metadata = $paymentIntent->metadata;
//            $metadata['booking_id'] = '1';
//
//            $paymentIntent->metadata = $metadata;
//            $paymentIntent->save();

        } catch (\Exception $e) {
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
            return response('',400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('',400);
        }

        // Handle the event
        switch ($event->type) {
            case 'charge.succeeded':
                $charge = $event->data->object;
//                $dataPayment = [
//                    'payment_date' => date('Y-m-d H:i:s'),
//                    'method_payment' => 1,
//                    'status_payment' => 0,
//                    'total_money' => $event->data->amount,
//                ];
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    public function complete()
    {
        return Inertia::render('Web/Booking/Complete');
    }

    public function edit($id)
    {

    }
}
