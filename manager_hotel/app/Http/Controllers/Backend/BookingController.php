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
use App\Repositories\Eloquent\TypeRoomRepository;
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
use Illuminate\Http\Request;

class BookingController extends BackendController
{
    protected $repository;
    protected $bookingRoomRepository;
    protected $bookingFoodRepository;
    protected $customerRepository;
    protected $roomRepository;
    protected $typeRoomRepository;
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
        $this->typeRoomRepository = app(TypeRoomRepository::class);
        $this->service = app(BookingService::class);
        $this->customerService = app(CustomerService::class);
        $this->roomService = app(RoomService::class);
        $this->bookingRoomService = app(BookingRoomService::class);
        $this->typeRoomService = app(TypeRoomService::class);
    }

    public function index(Request $request)
    {
//        dd($request->term);
        // dang lam search
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
        $customers = $this->customerRepository->get();

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
        $listRoom = $this->roomRepository->getListRoomByPeople(data_get($params, 'room'));
        $bookedRoom = $this->bookingRoomRepository->getListRoomBooked();
        $typesRoom = $this->typeRoomRepository->get();

        foreach (\App\Models\Enums\RoomStatusEnum::cases() as $key => $data) {
            $status[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Booking/RoomAvailable', [
            'rooms' => listFilterRoom($listRoom, $bookedRoom, formatDate($params["range"]['start']), formatDate($params["range"]['end'])),
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => formatDate($params["range"]['start']),
                'time_check_out' => formatDate($params["range"]['end']),
                'time_stay' => timeStay($params["range"]['start'], $params["range"]['end']),
            ],
            'typesRoom' => $typesRoom,
            'status' => $status,
        ]);
    }

    public function editFilterRoom(BookingRequest $request)
    {
        $params = $request->all();
        $rooms = formatDataRoom(data_get($params, 'rooms'), $this->roomRepository);
        $numberPeople = [];

        foreach ($rooms as $room) {
            if (empty($room['id'])) {
                array_push($numberPeople, $room['number_people']);
            }
        }

        $record = !empty($numberPeople) ? $this->roomRepository->getListRoomByPeople($numberPeople) : '';

        return Inertia::render('Admin/Booking/RoomAvailableForUpdate', [
            'bookRoom' => $rooms, // information old rooms
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => formatDate($params["range"]['start']),
                'time_check_out' => formatDate($params["range"]['end']),
                'time_stay' => timeStay($params["range"]['start'], $params["range"]['end']),
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
                $room = $this->roomRepository->find($value);

                $data = [
                    'room_id' => $value,
                    'booking_id' => $lastId,
                    'price' => data_get($params, 'price_each_room')[$key],
                    'number_people' => $room->number_people,
                    'time_check_in' => data_get($params, 'time_check_in'),
                    'time_check_out' => data_get($params, 'time_check_out'),
                ];

                if (!$this->bookingRoomService->store($data)) {
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('booking.index');
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
            $oldBookRoom = $this->bookingRoomRepository->getRoomBooked($id);
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
                        $room->status = \App\Models\Enums\RoomStatusEnum::VACANT->value;
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
        $customer = $this->customerRepository->find($booking->customer_id);
        $bookingRoom = $this->bookingRoomRepository->where('booking_id', $id)->with(['room'])->get();
        $bookingFood = $this->bookingFoodRepository->where('booking_id', $id)->with(['food'])->get();
        $status = getStatusRoom();

        return Inertia::render('Admin/Booking/Detail', [
            'booking' => $booking,
            'customer' => $customer,
            'bookingRoom' => $bookingRoom,
            'bookingFood' => $bookingFood,
            'status' => $status,
        ]);
    }

    public function updateStatus($id)
    {
        try {
            $params = request()->all();

            $statusPayment = data_get($params, 'status_payment');
            $statusBooking = data_get($params, 'status_booking');
            $bookingRoom = $this->bookingRoomRepository->where('booking_id', $id)->with(['room'])->get();
            $booking = $this->repository->find($id);

            if (empty($booking)) {
                return Redirect::route('booking.index');
            }

            $dataRoom = request()->only(['time_check_in', 'time_check_out']);
            $dataRoom['status'] = RoomStatusEnum::OCCUPIED->value;

            if ($statusBooking != BookingStatusEnum::CHECK_IN->value) {
                $dataRoom = [
                    'status' => RoomStatusEnum::VACANT->value,
                ];
            }

             if ($booking->status_booking == $statusBooking) {
                 session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
                 return Redirect::route('booking.detail', ['id' => $id]);
             }

             foreach ($bookingRoom as $data) {
                if ($dataRoom['status'] == data_get($data, 'room.status')->value && data_get($data, 'room.status')->value == RoomStatusEnum::OCCUPIED->value){
                    session()->flash('action_failed', 'Room '. data_get($data, 'room.name') .' does not check out so your reservation cannot check in');
                    return Redirect::route('booking.detail', ['id' => $id]);
                }
             }

            $booking->status_payment = $statusPayment;
            $booking->status_booking = $statusBooking;
            if (!$booking->save()) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('booking.index');
            }

            foreach (data_get($params, 'rooms') as $room) {
                if (!$this->roomRepository->update(data_get($room, 'room_id'), $dataRoom)) {
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
