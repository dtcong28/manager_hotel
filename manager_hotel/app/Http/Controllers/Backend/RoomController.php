<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\RoomRequest;
use App\Models\Enums\RoomStatusEnum;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\RoomService;
use App\Services\TypeRoomService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoomController extends BackendController
{
    protected $repository;
    protected $service;
    protected $typeRoomService;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(RoomRepository::class);
        $this->service = app(RoomService::class);
        $this->typeRoomService = app(TypeRoomService::class);
    }

    public function index()
    {
        $data = request()->all();
        $record = $this->service->index($data);

        $typesRoom = $this->typeRoomService->index($data);

        foreach (\App\Models\Enums\RoomStatusEnum::cases() as $key => $data) {
            $status[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }
        return Inertia::render('Admin/Rooms/Index', [
            'rooms' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'type_room_id' => $value->type_room_id,
                    'status' => $value->status,
                    'note' => $value->note,
                    'number_people' => $value->number_people,
                    'size' => $value->size,
                    'view' => $value->view,
                    'number_bed' => $value->number_bed,
                    'rent_per_night' => $value->rent_per_night,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            'typesRoom' => $typesRoom,
            'status' => $status,
        ]);
    }

    public function create()
    {
        $typesRoom = $this->typeRoomService->index(request()->all());

        foreach (\App\Models\Enums\RoomStatusEnum::cases() as $key => $data) {
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
                return Redirect::route('rooms.index');
            }

            if ($this->service->store($params)) {
                session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
            } else {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
            }
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

        $typesRoom = $this->typeRoomService->index(request()->all());

        foreach (\App\Models\Enums\RoomStatusEnum::cases() as $key => $data) {
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
                return Redirect::route('rooms.index');
            }

            $params = $request->all();

            if ($this->service->update($id, $params)) {
                session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
            } else {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('rooms.index');
    }
}
