<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Customer\CustomerRequest;
use App\Repositories\Eloquent\BookingRepository;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends FrontendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(BookingRepository::class);
        $this->service = app(BookingService::class);
    }

    public function index()
    {
//        return Inertia::render('Web/Home/Index');
    }

    public function filterRoom(Request $request)
    {
        dd($request->all());
        return Inertia::render('Web/Booking/RoomAvailable');
    }

    public function create()
    {

    }

    public function edit($id)
    {

    }
}
