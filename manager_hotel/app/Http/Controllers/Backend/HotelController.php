<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Hotel\HotelRequest;
use App\Repositories\Eloquent\HotelRepository;
use App\Services\HotelService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class HotelController extends BackendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(HotelRepository::class);
        $this->service = app(HotelService::class);
    }

    public function create()
    {
        $hotel = $this->repository->first();

        if(empty($hotel)){
            return Inertia::render('Admin/Hotel/Create', [ 'hotel' => '' ]);
        } else {
            return Inertia::render('Admin/Hotel/Create',[ 'hotel' => $hotel ]);
        }

    }

    public function store(HotelRequest $request)
    {
        try {
            $params = $request->all();

            $hotel = $this->repository->first();

            if(empty($hotel)){
                if (!$this->service->store($params)) {
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('hotel.create');
                }
            } else {
                if (!($this->service->update($hotel->id, $params))) {
                    session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                    return Redirect::route('hotel.create');
                };
            }

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('hotel.create');
    }
}
