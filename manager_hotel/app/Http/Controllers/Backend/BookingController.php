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

    public function __construct(BookingRoomRepository $bookingRoomRepository,BookingRoomService $bookingRoomService, BookingRepository $bookingRepository, BookingService $bookingService, CustomerRepository $customerRepository, CustomerService $customerService, RoomRepository $roomRepository, RoomService $roomService)
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

        return Inertia::render('Admin/Booking/RoomAvailable', [
            'rooms' => $record,
            'bookingInfor' => [
                'customer' => $params["name"],
                'type_booking' => $params["type_booking"],
                'time_check_in' => date('Y-m-d', strtotime($params["range"]['start'])),
                'time_check_out' => date('Y-m-d', strtotime($params["range"]['end'])),
            ]
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

            foreach (data_get($params, 'rooms') as $value) {
                $data['room_id'] = $value;
                $data['booking_id'] = $lastId;

                if (!$this->bookingRoomService->store($data)) {
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('booking.index');
                }

                $room = $this->roomRepository->find($value);
                if(!empty($room))
                {
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
        ]);
    }

    public function update(BookingRequest $request, $id)
    {

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

            $bookingRoom = $this->bookingRoomRepository->findByField('booking_id',$id);
            foreach ($bookingRoom as $value) {
                $roomId = $value->room_id;
                $room = $this->roomRepository->find($roomId);
                if(!empty($room))
                {
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

        return Redirect::route('rooms.index');
    }

}
