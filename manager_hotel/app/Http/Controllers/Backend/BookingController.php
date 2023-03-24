<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Booking\BookingRequest;
use App\Models\Enums\BookingStatusEnum;
use App\Models\Enums\PaymentStatusEnum;
use App\Models\Enums\RoomStatusEnum;
use App\Repositories\Eloquent\BookingFoodRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\BookingRoomRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\BookingRoomService;
use App\Services\BookingService;
use App\Services\CustomerService;
use App\Services\RoomService;
use App\Services\TypeRoomService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends BackendController
{
    protected $repository;
    protected $bookingRoomRepository;
    protected $bookingFoodRepository;
    protected $customerRepository;
    protected $roomRepository;
    protected $service;
    protected $customerService;
    protected $roomService;
    protected $bookingRoomService;
    protected $typeRoomService;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(BookingRepository::class);
        $this->bookingRoomRepository = app(BookingRoomRepository::class);
        $this->bookingFoodRepository = app(BookingFoodRepository::class);
        $this->customerRepository = app(CustomerRepository::class);
        $this->roomRepository = app(RoomRepository::class);
        $this->service = app(BookingService::class);
        $this->customerService = app(CustomerService::class);
        $this->roomService = app(RoomService::class);
        $this->bookingRoomService = app(BookingRoomService::class);
        $this->typeRoomService = app(TypeRoomService::class);
    }

    public function index()
    {
        $record = $this->repository->getListBooking();

        return Inertia::render('Admin/Booking/Index', [
            'bookings' => $record,
            'status' => $record->map(function ($value) {
                return [
                    'booking' => [
                        'label' => BookingStatusEnum::statusLabel((int)$value->status_booking),
                        'class' => BookingStatusEnum::statusBg((int)$value->status_booking),
                    ],
                    'payment' => [
                        'label' => PaymentStatusEnum::statusLabel((int)$value->status_payment),
                        'class' => PaymentStatusEnum::statusBg((int)$value->status_payment),
                    ]
                ];
            }),
        ]);
    }

    public function create()
    {
        $params = request()->all();
        $customers = $this->customerService->index($params);

        foreach (\App\Models\Enums\TypeBookingEnum::cases() as $key => $data) {
            $typeBooking[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Booking/Create', [
            'customers' => $customers->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                ];
            }),
            'typeBooking' => $typeBooking,
        ]);
    }

    public function filterRoom(BookingRequest $request)
    {
        $params = $request->all();

        $numberPeople = data_get($params, 'room');
        $checkIn = date('Y-m-d', strtotime($params["range"]['start']));
        $checkOut = date('Y-m-d', strtotime($params["range"]['end']));

        $record = $this->roomRepository->getListFilterRoom($numberPeople, $checkIn, $checkOut);

        $start = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($params["range"]['start'])));
        $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($params["range"]['end'])));

        $typesRoom = $this->typeRoomService->index([]);

        foreach (\App\Models\Enums\RoomStatusEnum::cases() as $key => $data) {
            $status[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Booking/RoomAvailable', [
            'rooms' => $record,
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => date('Y-m-d', strtotime($params["range"]['start'])),
                'time_check_out' => date('Y-m-d', strtotime($params["range"]['end'])),
                'time_stay' => $start->diffInDays($end),
            ],
            'typesRoom' => $typesRoom,
            'status' => $status,
        ]);
    }

    public function editFilterRoom(BookingRequest $request)
    {
        // chưa lấy được ảnh
        $params = $request->all();

        // Xử lí lại dữ liệu
        $rooms = [];
        $roomID = [];
        $roomName = [];
        $roomNumberPeople = [];
        foreach (data_get($params, 'rooms') as $value) {
            if (array_key_exists('id', $value)) {
                array_push($roomID, $value);
            }
            if (array_key_exists('name', $value)) {
                array_push($roomName, $value);
            }
            if (array_key_exists('number_people', $value)) {
                array_push($roomNumberPeople, $value);
            }
        }

        foreach ($roomNumberPeople as $key => $value) {
            $rooms[$key] = [
                'id' => array_key_exists($key, $roomID) ? data_get($roomID[$key], 'id') : '',
                'name' => array_key_exists($key, $roomName) ? data_get($roomName[$key], 'name') : '',
                'number_people' => array_key_exists($key, $roomNumberPeople) ? data_get($roomNumberPeople[$key], 'number_people') : '',
                'rent_per_night' => array_key_exists($key, $roomID) ? $this->roomRepository->getDetailRoom(data_get($roomID[$key], 'id'))['rent_per_night'] : '',
            ];
        }

        $numberPeople = [];

        foreach ($rooms as $room) {
            if (empty($room['id'])) {
                array_push($numberPeople, $room['number_people']);
            }
        }

        $record = !empty($numberPeople) ? $this->roomRepository->getListFilterRoom($numberPeople, date('Y-m-d', strtotime($params["range"]['start']))) : '';

        $start = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($params["range"]['start'])));
        $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($params["range"]['end'])));

        return Inertia::render('Admin/Booking/RoomAvailableForUpdate', [
            'bookRoom' => $rooms, // information old rooms
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => date('Y-m-d', strtotime($params["range"]['start'])),
                'time_check_out' => date('Y-m-d', strtotime($params["range"]['end'])),
                'time_stay' => $start->diffInDays($end),
            ],
            'filterRoom' => $record, // information new rooms is booked
            'idBooking' => data_get($params, 'id_booking')
        ]);

    }

    public function store(BookingRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $params['status_payment'] = \App\Models\Enums\PaymentStatusEnum::UNPAID->value;
            $params['status_booking'] = \App\Models\Enums\BookingStatusEnum::EXPECTED_ARRIVAL->value;

            if (!$this->service->store($params)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('booking.index');
            }
            $lastId = session()->pull('last_id');

            foreach (data_get($params, 'rooms') as $key => $value) {
                $data['room_id'] = $value;
                $data['booking_id'] = $lastId;
                $data['price'] = data_get($params, 'price_each_room')[$key];

                $room = $this->roomRepository->find($value);
                $data['number_people'] = $room->number_people;

                if (!$this->bookingRoomService->store($data)) {
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('booking.index');
                }

                if (!empty($room)) {
                    $room->status = \App\Models\Enums\RoomStatusEnum::EXPECTED_ARRIVAL->value;
                    $room->save();
                }
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('booking.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('booking.index');
        }

        foreach (\App\Models\Enums\TypeBookingEnum::cases() as $key => $data) {
            $typeBooking[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }
        $data = $this->repository->getDetailBooking($id);

        if (empty($data)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('booking.index');
        }

        return Inertia::render('Admin/Booking/Edit', [
            'bookingRoom' => $data,
            'typeBooking' => $typeBooking,
            'idBooking' => $id,
        ]);
    }

    public function update(BookingRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = data_get($request->all(), 'form');

            $oldBookRoom = $this->bookingRoomRepository->getListRoomBooked($id);

            $newBookedRoom = [];
            foreach (data_get($params, 'book_room') as $value) {
                if (!empty(data_get($value, 'id'))) {
                    array_push($newBookedRoom, data_get($value, 'id'));
                }
            }

            // Old Room
            foreach ($oldBookRoom as $room) {
                if (!in_array($room['room_id'], $newBookedRoom)) {
                    // delete booking
                    if (!$this->bookingRoomService->destroy($room['id'])) {
                        DB::rollback();
                        session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                        return Redirect::route('booking.index');
                    }

                    // update status room is vacant
                    $room = $this->roomRepository->find($room['room_id']);
                    if (!empty($room)) {
                        $room->status = \App\Models\Enums\RoomStatusEnum::VACANT->value;
                        $room->save();
                    }
                } else {
                    //update number_people
                    $booked = $this->bookingRoomRepository->find($room['id']);

                    foreach (data_get($params, 'book_room') as $key => $value) {
                        if (data_get($value, 'id') == $room['room_id']) {
                            $booked->number_people = data_get($value, 'number_people');
                            $booked->price = data_get($params, 'price_each_room')[$key];
                            $booked->save();
                        }
                    }
                }
            }

            // New Rooms is added
            foreach (data_get($params, 'select_rooms') as $key => $value) {
                // add new booking with room_id
                if (is_int($value)) {
                    $data = [
                        'booking_id' => $id,
                        'room_id' => $value,
                        'price' => data_get($params, 'price_each_room')[$key],
                        'number_people' => data_get($params, 'book_room')[$key]['number_people']
                    ];

                    if (!$this->bookingRoomService->store($data)) {
                        DB::rollback();
                        session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                        return Redirect::route('booking.index');
                    }

                    // update status room is expected arrival
                    $room = $this->roomRepository->find($value);
                    if (!empty($room)) {
                        $room->status = \App\Models\Enums\RoomStatusEnum::EXPECTED_ARRIVAL->value;
                        $room->save();
                    }
                }
            }

            // update info booking
            $booking = $this->repository->find($id);
            if (!empty($booking)) {
                $booking->type_booking = $params['type_booking']['value'];
                $booking->time_check_in = $params['time_check_in'];
                $booking->time_check_out = $params['time_check_out'];
                $booking->number_rooms = count($params['book_room']);
                $booking->save();
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            DB::rollback();
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }
        return Redirect::route('booking.index');
    }

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return Redirect::route('booking.index');
            }

            if (empty($this->repository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('booking.index');
            }

            $bookingRoom = $this->bookingRoomRepository->findByField('booking_id', $id);
            foreach ($bookingRoom as $value) {
                $roomId = $value->room_id;
                $room = $this->roomRepository->find($roomId);
                if (!empty($room)) {
                    $room->status = \App\Models\Enums\RoomStatusEnum::VACANT->value;
                    $room->time_check_in = NULL;
                    $room->time_check_out = NULL;
                    $room->save();
                }
                $this->bookingRoomRepository->destroy($value->id);
            }

            $bookingFood = $this->bookingFoodRepository->findByField('booking_id', $id);
            foreach ($bookingFood as $value) {
                $this->bookingFoodRepository->destroy($value->id);
            }

            $this->repository->destroy($id);

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return redirect()->back();
    }

    public function detail($id)
    {
        $booking = $this->repository->find($id);
//        dd($booking);
        $a = collect($booking)->map(function ($value) {
            return [
                'id' => data_get($value, 'id'),
                'time_check_in' => data_get($value, 'time_check_in'),
                'time_check_out' => data_get($value, 'time_check_out'),
                'number_rooms' => data_get($value, 'number_rooms'),
                'status_payment' => data_get($value, 'status_payment'),
                'status_booking' => data_get($value, 'status_booking'),
            ];
        });
//        dd($a);
        $customer = $this->customerRepository->find($booking->customer_id);
        $bookingRoom = $this->bookingRoomRepository->where('booking_id', $id)->with(['room'])->get();
        $bookingFood = $this->bookingFoodRepository->where('booking_id', $id)->with(['food'])->get();
        return Inertia::render('Admin/Booking/Detail', [
            'booking' => $booking,
            'customer' => $customer,
            'bookingRoom' => $bookingRoom,
            'bookingFood' => $bookingFood,
        ]);
    }

    public function updateStatus($id)
    {
        try {
            $params = request()->all();
            $statusPayment = data_get($params, 'status_payment');
            $statusBooking = data_get($params, 'status_booking');
            $booking = $this->repository->find($id);

            if (empty($booking)) {
                return Redirect::route('booking.index');
            }

            // chưa xử lý cùng 1 phòng mà phòng kia chưa check out-> phòng còn lại sẽ k được update tình trạng phòng là 2
            $booking->status_payment = $statusPayment;
            $booking->status_booking = $statusBooking;
            if(!$booking->save()) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('booking.index');
            }

            $dataRoom = request()->only(['time_check_in', 'time_check_out']);
            $dataRoom['status'] = RoomStatusEnum::OCCUPIED->value;

            if ($statusBooking != BookingStatusEnum::CHECK_IN->value) {
                $dataRoom = [
                    'time_check_in' => null,
                    'time_check_out' => null,
                ];
                if ($statusBooking == BookingStatusEnum::CHECK_OUT->value) {
                    $dataRoom['status'] = RoomStatusEnum::VACANT->value;
                }
                if ($statusBooking == BookingStatusEnum::EXPECTED_ARRIVAL->value) {
                    $dataRoom['status'] = RoomStatusEnum::EXPECTED_ARRIVAL->value;
                }
            };

            foreach (data_get($params, 'rooms') as $room) {
                if(!$this->roomRepository->update(data_get($room, 'room_id'), $dataRoom)){
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                    return Redirect::route('booking.index');
                }
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return Redirect::route('booking.detail', ['id' => $id]);
    }
}
