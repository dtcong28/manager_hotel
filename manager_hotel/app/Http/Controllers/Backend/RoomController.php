<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\RoomRequest;
use App\Models\Room;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\RoomService;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
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
                    'max_person' => $value->max_person,
                    'size' => $value->size,
                    'view' => $value->view,
                    'number_bed' => $value->number_bed,
                    'rent_per_night' => $value->rent_per_night,
                    'image' => $value->image,
                ];
            }),
            'typesRoom' => $typesRoom,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Rooms/Create');
    }

    public function store(RoomRequest $request)
    {
        try {
            $this->setFormData($request->all());

            $params = $this->getFormData();

//            Bị lỗi Serialization of 'Illuminate\Http\UploadedFile' is not allowed
//            if (!$this->roomService->store($params)) {
//                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
//
//                return Redirect::route('rooms.index');
//            }
//
//            if ($request->hasFile('image')) {
//                Room::class->addMediaFromRequest('image')->toMediaCollection();
//            }
            $room = Room::create($params);

            if ($request->hasFile('image')) {
                $room->addMediaFromRequest('image')
                    ->usingName($params->name)
                    ->toMediaCollection();
            }


            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        $this->cleanFormData();

        return Redirect::route('rooms.index');
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
