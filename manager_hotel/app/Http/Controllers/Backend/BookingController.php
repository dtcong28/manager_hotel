<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Booking\BookingRequest;
use App\Mail\BookingMail;
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
use Illuminate\Support\Facades\Mail;
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
        $record = $this->repository->getSearchBooking($request->search);

        return Inertia::render('Admin/Booking/Index', [
            'bookings' => $record,
            'status' => $record->map(function ($value) {
                return [
                    'booking_class' => BookingStatusEnum::statusBg($value->status_booking->value),
                    'payment_class' => PaymentStatusEnum::statusBg($value->status_payment->value),
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

        $data = [
            'time_check_in' => data_get($params, 'time_check_in'),
            'time_check_out' => data_get($params, 'time_check_out'),
            'number_people' => data_get($params, 'room'),
        ];

        return Inertia::render('Admin/Booking/RoomAvailable', [
            'rooms' => $this->roomRepository->getListFilterRoom($data),
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => $params["time_check_in"],
                'time_check_out' => $params["time_check_out"],
                'time_stay' => timeStay($params["time_check_in"], $params["time_check_out"]),
            ]
        ]);
    }

    public function editFilterRoom(Request $request)
    {
        $params = $request->all();
        $rooms = formatDataRoom(data_get($params, 'rooms'), $this->roomRepository);
        $numberPeople = [];

        foreach ($rooms as $room) {
            if (empty($room['id'])) {
                array_push($numberPeople, $room['number_people']);
            } else {
                $listBookingByRoom = $this->repository->getListBookingByRoom($room['id'], $params['id_booking']);
                foreach ($listBookingByRoom as $data) {
                    if (checkInRange($data['time_check_in'], $data['time_check_out'], $params['time_check_in']) || checkOutRange($data['time_check_in'], $data['time_check_out'], $params['time_check_out'])) {
                        session()->flash('action_failed', "Check-in and check-out time is not suitable");
                        return Redirect::route('booking.edit', ['booking' => $params['id_booking']]);
                    }
                }
            }
        }

        $data = [
            'time_check_in' => data_get($params, 'time_check_in'),
            'time_check_out' => data_get($params, 'time_check_out'),
            'number_people' => !empty($numberPeople) ? $numberPeople : [],
        ];
        $filterRoom = $this->roomRepository->getListFilterRoom($data);

        return Inertia::render('Admin/Booking/RoomAvailableForUpdate', [
            'bookRoom' => $rooms, // information old rooms
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => $params["time_check_in"],
                'time_check_out' => $params["time_check_out"],
                'time_stay' => timeStay($params["time_check_in"], $params["time_check_out"]),
            ],
            'filterRoom' => $filterRoom, // information new rooms is booked
            'idBooking' => data_get($params, 'id_booking')
        ]);

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $params['status_payment'] = \App\Models\Enums\PaymentStatusEnum::UNPAID->value;
            $params['status_booking'] = \App\Models\Enums\BookingStatusEnum::EXPECTED_ARRIVAL->value;
            $customer = $this->customerRepository->find(data_get(data_get($params, 'customer'), 'id'));

            if (!$this->service->store($params)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('booking.index');
            }
            $lastId = session()->pull('last_id');

            foreach (data_get($params, 'rooms') as $key => $value) {
                $room = $this->roomRepository->find($value);

                $data[$key] = [
                    'room_id' => $value,
                    'booking_id' => $lastId,
                    'price' => data_get($params, 'price_each_room')[$key],
                    'number_people' => $room->number_people,
                ];

                if (!$this->bookingRoomService->store($data[$key])) {
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('booking.index');
                }
                $data[$key]['room_name'] = $room->name;
            }

            Mail::to($customer->email)->send(new BookingMail($data));

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

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = data_get($request->all(), 'form');
            $oldBookRoom = $this->bookingRoomRepository->getRoomBooked($id);
            $booking = $this->repository->find($id);
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
                    if (!empty($room) && $booking->status_booking->value == \App\Models\Enums\BookingStatusEnum::CHECK_IN->value){
                        $room->status = \App\Models\Enums\RoomStatusEnum::OCCUPIED->value;
                        $room->save();
                    }
                }
            }

            // update info booking
            if (!empty($booking)) {
                $booking->type_booking = $params['type_booking'];
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

             if ($booking->status_booking->value == $statusBooking) {
                 session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
                 return Redirect::route('booking.detail', ['id' => $id]);
             }

             foreach ($bookingRoom as $data) {
                 if ($dataRoom['status'] == data_get($data, 'room.status')->value && data_get($data, 'room.status')->value == RoomStatusEnum::OCCUPIED->value){
                     session()->flash('action_failed', 'Room ' . data_get($data, 'room.name') . ' does not check out so your reservation cannot check in');
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
