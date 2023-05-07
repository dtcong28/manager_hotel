<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Eloquent\RoomRepository;
use App\Repositories\Eloquent\TypeRoomRepository;
use App\Services\RoomService;
use App\Services\TypeRoomService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomFEController extends FrontendController
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
        $record = $this->repository->getSearchWebRoom($request->all());
        $typesRoom = $this->typeRoomRepository->get();

        return Inertia::render('Web/Room/Index', [
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
            'typesRoom' => $typesRoom,
        ]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        $record = $data->toArray();

        foreach ($data->getMedia('images') as $key => $value) {
            $record['images'][$key] = $value->getUrl();
        }

        $typesRoom = $this->typeRoomRepository->get();;

        return Inertia::render('Web/Room/Detail', [
            'room' => $record,
            'typesRoom' => $typesRoom,
        ]);
    }
}
