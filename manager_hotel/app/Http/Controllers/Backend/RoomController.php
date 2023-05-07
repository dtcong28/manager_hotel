<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\RoomRequest;
use App\Mail\CancelRoomBookingMail;
use App\Models\Enums\BookingStatusEnum;
use App\Models\Enums\RoomStatusEnum;
use App\Repositories\Eloquent\RoomRepository;
use App\Repositories\Eloquent\TypeRoomRepository;
use App\Services\RoomService;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoomController extends BackendController
{
    protected $repository;
    protected $service;
    protected $typeRoomService;
    protected $typeRoomRepository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(RoomRepository::class);
        $this->service = app(RoomService::class);
        $this->typeRoomService = app(TypeRoomService::class);
        $this->typeRoomRepository = app(TypeRoomRepository::class);
    }

    public function index(Request $request)
    {
        $record = $this->repository->getSearchRoom($request->search);
        $typesRoom = $this->typeRoomRepository->get();

        return Inertia::render('Admin/Rooms/Index', [
            'rooms' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'type_room' => data_get($value,'typeRoom.name'),
                    'status' => $value->status,
                    'status_label' => $value->status_label,
                    'note' => $value->note,
                    'number_people' => $value->number_people,
                    'size' => $value->size,
                    'view' => $value->view,
                    'number_bed' => $value->number_bed,
                    'rent_per_night' => $value->rent_per_night,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            'record' => $record,
        ]);
    }

    public function create()
    {
        $typesRoom = $this->typeRoomRepository->get();

        foreach (RoomStatusEnum::cases() as $key => $data) {
            $status[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Rooms/Create', [
            'typesRoom' => $typesRoom,
            'status' => $status,
        ]);
    }

    public function store(RoomRequest $request)
    {
        try {
            $params = $request->all();

            if (empty($params)) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
                return Redirect::route('rooms.index');
            }

            if (!($this->service->store($params))) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
                return Redirect::route('rooms.index');
            };

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('rooms.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('rooms.index');
        }

        $data = $this->repository->find($id);
        $record = $data->toArray();

        foreach ($data->getMedia('images') as $key => $value) {
            $record['images'][$key] = $value->getUrl();
        }

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('rooms.index');
        }

        $typesRoom = $this->typeRoomRepository->get();;

        foreach (RoomStatusEnum::cases() as $key => $data) {
            $status[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Rooms/Edit', [
            'room' => $record,
            'typesRoom' => $typesRoom,
            'status' => $status,
        ]);
    }

    public function update(RoomRequest $request, $id)
    {
        try {
            if (empty($id) || empty($request)) {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('rooms.index');
            }

            $params = $request->all();

            if (!($this->service->update($id, $params))) {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('rooms.index');
            };

            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('rooms.index');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            if (empty($id)) {
                return redirect(getBackUrl());
            }

            $room = $this->repository->find($id);
            if (empty($room)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            // gửi mail thông báo cho khách hàng phòng bị hủy
            $bookingRoom = $room->bookingRoom()->with(['booking.customer','room'])->get();
            foreach ($bookingRoom as $value){
                $emailCustomer = data_get($value, 'booking.customer.email');
                $infoBooking = [
                    'info' => data_get($value, 'booking'),
                    'room' => data_get($value, 'room.name'),
                ];

                if(data_get($value, 'booking.status_booking.value') != BookingStatusEnum::CHECK_OUT->value){
                    Mail::to($emailCustomer)->send(new CancelRoomBookingMail($infoBooking));
                }
            }

            // xóa room trong bảng booking room của phòng tương ứng đó
            if(($room->bookingRoom()->get())->isNotEmpty() && !$room->bookingRoom()->delete()){
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            if (!$this->service->destroy($id)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return redirect(getBackUrl());
    }
}
