<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Food\FoodRequest;
use App\Repositories\Eloquent\BookingFoodRepository;
use App\Repositories\Eloquent\FoodRepository;
use App\Services\BookingFoodService;
use App\Services\FoodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FoodController extends BackendController
{
    protected $repository;
    protected $bookFoodRepository;
    protected $service;
    protected $bookFoodService;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(FoodRepository::class);
        $this->bookFoodRepository = app(BookingFoodRepository::class);
        $this->service = app(FoodService::class);
        $this->bookFoodService = app(BookingFoodService::class);
    }

    public function index(Request $request)
    {
        $record = $this->repository->getSearchFood($request->search);

        return Inertia::render('Admin/Food/Index', [
            'food' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'price' => $value->price,
                    'description' => $value->description,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            'record' => $record,
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
        }

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

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return redirect(getBackUrl());
            }

            if (empty($this->repository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            if (!$this->service->destroy($id)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            $bookedFood = $this->bookFoodRepository->where('food_id', $id)->get();
            if (!empty($bookedFood)) {
                foreach ($bookedFood as $data) {
                    $this->bookFoodService->destroy($data['id']);
                }
            }
            // gui mail cho user dat mon an do

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return redirect(getBackUrl());
    }
}
