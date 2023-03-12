<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Food\FoodRequest;
use App\Repositories\Eloquent\FoodRepository;
use App\Services\FoodService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FoodController extends BackendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(FoodRepository::class);
        $this->service = app(FoodService::class);
    }

    public function index()
    {
        $data = request()->all();
        $record = $this->service->index($data);

        return Inertia::render('Admin/Food/Index',[
            'food' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'price' => $value->price,
                    'description' => $value->description,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Food/Create');
    }

    public function store(FoodRequest $request)
    {
        try {
            $params = $request->all();

            if (empty($params)) {
                return Redirect::route('food.index');
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

        return Redirect::route('food.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('food.index');
        }

        $data = $this->repository->find($id);
        $record = $data->toArray();

        foreach ($data->getMedia('images') as $key => $value) {
            $record['images'][$key] = $value->getUrl();
//            $record['images'][$key] = $value;
        }
//        dd($record);
        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('food.index');
        }

        return Inertia::render('Admin/Food/Edit', [
            'food' => $record,
        ]);
    }

    public function update(FoodRequest $request, $id)
    {
        try {
            if (empty($id) || empty($request)) {
                return Redirect::route('food.index');
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

        return Redirect::route('food.index');
    }
}
