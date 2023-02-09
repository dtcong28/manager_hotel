<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\TypeRoomRequest;
use App\Models\TypeRoom;
use App\Repositories\Eloquent\TypeRoomRepository;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TypeRoomController extends BackendController
{
    protected $typeRoomRepository;
    protected $typeRoomService;

    public function __construct(TypeRoomRepository $typeRoomRepository, TypeRoomService $typeRoomService)
    {
        parent::__construct();
        $this->typeRoomRepository = $typeRoomRepository;
        $this->typeRoomService = $typeRoomService;
    }

    public function index()
    {
        $data = request()->all();
        $record = $this->typeRoomService->index($data);

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
            $this->setFormData($request->all());
            $params = $this->getFormData();

            if (!$this->typeRoomService->store($params)) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('types-room.index');
            }

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        $this->cleanFormData();

        return Redirect::route('types-room.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('types-room.index');
        }

        $record = $this->typeRoomRepository->find($id)->toArray();

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
        $this->setFormData($request->all());
        $params = $this->getFormData();

        try {
            if (empty($id) || empty($params)) {
                return Redirect::route('types-room.index');
            }

            if (!$this->typeRoomService->update($id, $params)) {
                $this->cleanFormData();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('types-room.index');
            }

            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        $this->cleanFormData();

        return Redirect::route('types-room.index');
    }

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return Redirect::route('types-room.index');
            }

            if (empty($this->typeRoomRepository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('types-room.index');
            }

            if (!$this->typeRoomService->destroy($id)) {
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
