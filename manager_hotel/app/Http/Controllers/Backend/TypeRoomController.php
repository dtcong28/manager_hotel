<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\TypeRoomRequest;
use App\Repositories\Eloquent\RoomRepository;
use App\Repositories\Eloquent\TypeRoomRepository;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TypeRoomController extends BackendController
{
    protected $repository;
    protected $service;
    protected $roomRepository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(TypeRoomRepository::class);
        $this->roomRepository = app(RoomRepository::class);
        $this->service = app(TypeRoomService::class);
    }

    public function index()
    {
        $data = request()->all();
        $record = $this->service->index($data);

        return Inertia::render('Admin/TypesRoom/Index', [
            'typesRoom' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                ];
            })
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/TypesRoom/Create');
    }

    public function store(TypeRoomRequest $request)
    {
        try {
            $params = $request->all();

            if (!$this->service->store($params)) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('types-room.index');
            }

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('types-room.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('types-room.index');
        }

        $record = $this->repository->find($id)->toArray();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('types-room.index');
        }

        return Inertia::render('Admin/TypesRoom/Edit', [
            'typeRoom' => $record
        ]);
    }

    public function update(Request $request, $id)
    {
        $params = $request->all();

        try {
            if (empty($id) || empty($params)) {
                return Redirect::route('types-room.index');
            }

            if (!$this->service->update($id, $params)) {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('types-room.index');
            }

            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('types-room.index');
    }

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return Redirect::route('types-room.index');
            }

            if (empty($this->repository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('types-room.index');
            }

            $rooms = $this->roomRepository->findByField('type_room_id', $id);
            foreach ($rooms as $value) {
                $this->roomRepository->destroy($value->id);
            }

            if (!$this->service->destroy($id)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('types-room.index');
            }

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return Redirect::route('types-room.index');
    }
}
