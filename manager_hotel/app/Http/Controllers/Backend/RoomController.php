<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\RoomRequest;
use App\Models\Enums\RoomStatusEnum;
use App\Models\Room;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\RoomService;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RoomController extends BackendController
{
    protected $roomRepository;
    protected $roomService;
    protected $typeRoomService;

    public function __construct(RoomRepository $roomRepository, RoomService $roomService, TypeRoomService $typeRoomService)
    {
        parent::__construct();
        $this->roomRepository = $roomRepository;
        $this->roomService = $roomService;
        $this->typeRoomService = $typeRoomService;
    }

    public function index()
    {
        $data = request()->all();
        $record = $this->roomService->index($data);

        $typesRoom = $this->typeRoomService->index($data);
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

            if ($this->roomService->store($params)) {
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

        $data = $this->roomRepository->find($id);
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

            if ($this->roomService->update($id, $params)) {
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

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return Redirect::route('rooms.index');
            }

            if (empty($this->roomRepository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('rooms.index');
            }

            if (!$this->roomService->destroy($id)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('rooms.index');
            }

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return Redirect::route('rooms.index');
    }

}
