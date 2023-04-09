<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\TypeRoomRequest;
use App\Repositories\Eloquent\RoomRepository;
use App\Repositories\Eloquent\TypeRoomRepository;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function index(Request $request)
    {
        $record = $this->repository->getSearchTypeRoom($request->search);

        return Inertia::render('Admin/TypesRoom/Index', [
            'typesRoom' => $record,
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
        DB::beginTransaction();
        try {
            if (empty($id)) {
                return Redirect::route('types-room.index');
            }

            $typeRoom = $this->repository->find($id);
            if (empty($typeRoom)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('types-room.index');
            }

            // xóa booking liên quan đến type của phòng đó
            $rooms = $typeRoom->room()->get();
            foreach($rooms as $room) {
                $booking = $room->bookingRoom()->get();
                if($booking->isNotEmpty() && !$room->bookingRoom()->delete()){
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                    return redirect(getBackUrl());
                }
            }

            // xóa phòng
            if($rooms->isNotEmpty() && !$typeRoom->room()->delete()){
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
                DB::rollback();

                return redirect(getBackUrl());
            }

            // xóa loại phòng
            if (!$this->service->destroy($id)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
                DB::rollback();

                return Redirect::route('types-room.index');
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return Redirect::route('types-room.index');
    }
}
