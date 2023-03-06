<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Booking\BookingRequest;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\BookingRoomRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\BookingRoomService;
use App\Services\BookingService;
use App\Services\CustomerService;
use App\Services\RoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends BackendController
{
    protected $bookingRepository;
    protected $bookingRoomRepository;
    protected $customerRepository;
    protected $roomRepository;
    protected $bookingService;
    protected $customerService;
    protected $roomService;
    protected $bookingRoomService;

    public function __construct(BookingRoomRepository $bookingRoomRepository, BookingRoomService $bookingRoomService, BookingRepository $bookingRepository, BookingService $bookingService, CustomerRepository $customerRepository, CustomerService $customerService, RoomRepository $roomRepository, RoomService $roomService)
    {
        parent::__construct();
        $this->bookingRepository = $bookingRepository;
        $this->bookingRoomRepository = $bookingRoomRepository;
        $this->customerRepository = $customerRepository;
        $this->roomRepository = $roomRepository;
        $this->bookingService = $bookingService;
        $this->customerService = $customerService;
        $this->roomService = $roomService;
        $this->bookingRoomService = $bookingRoomService;
    }

    public function index()
    {
        $record = $this->bookingRepository->getListBooking();

        return Inertia::render('Admin/Booking/Index', [
            'bookings' => $record,
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

        $record = $this->roomRepository->getListFilterRoom(data_get($params, 'room'));

        $start = Carbon::createFromFormat('Y-m-d',  date('Y-m-d', strtotime($params["range"]['start'])));
        $end = Carbon::createFromFormat('Y-m-d',  date('Y-m-d', strtotime($params["range"]['end'])));

        return Inertia::render('Admin/Booking/RoomAvailable', [
            'rooms' => $record,
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => date('Y-m-d', strtotime($params["range"]['start'])),
                'time_check_out' => date('Y-m-d', strtotime($params["range"]['end'])),
                'time_stay' => $start->diffInDays($end),
            ]
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

        $record = !empty($numberPeople) ? $this->roomRepository->getListFilterRoom($numberPeople) : '';

        $start = Carbon::createFromFormat('Y-m-d',  date('Y-m-d', strtotime($params["range"]['start'])));
        $end = Carbon::createFromFormat('Y-m-d',  date('Y-m-d', strtotime($params["range"]['end'])));

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

            if (!$this->bookingService->store($params)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('booking.index');
            }
            $lastId = session()->pull('last_id');

            foreach (data_get($params, 'rooms') as $key=>$value) {
                $data['room_id'] = $value;
                $data['booking_id'] = $lastId;
                $data['price'] = data_get($params, 'price_each_room')[$key];

                if (!$this->bookingRoomService->store($data)) {
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('booking.index');
                }

                $room = $this->roomRepository->find($value);
                if (!empty($room)) {
                    $room->status = \App\Models\Enums\RoomStatusEnum::OCCUPIED->value;
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
        $data = $this->bookingRepository->getDetailBooking($id);

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
                    //$this->bookingRoomService->destroy($room['id']);
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

                    foreach (data_get($params, 'book_room') as $value) {
                        if (data_get($value, 'id') == $room['room_id']) {
                            $booked->number_people = data_get($value, 'number_people');
                            $booked->save();
                        }
                    }
                }
            }

            // New Rooms is added
            foreach (data_get($params, 'select_rooms') as $value) {
                // add new booking with room_id
                $data = [
                    'booking_id' => $id,
                    'room_id' => $value,
                ];
               // $this->bookingRoomService->store($data);
                if (!$this->bookingRoomService->store($data)) {
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                    return Redirect::route('booking.index');
                }

                // update status room is occupied
                $room = $this->roomRepository->find($value);
                if (!empty($room)) {
                    $room->status = \App\Models\Enums\RoomStatusEnum::OCCUPIED->value;
                    $room->save();
                }
            }

            // update info booking
            $booking = $this->bookingRepository->find($id);
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

            if (empty($this->bookingRepository->find($id))) {
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

            $this->bookingRepository->destroy($id);

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return redirect()->back();
    }

}
