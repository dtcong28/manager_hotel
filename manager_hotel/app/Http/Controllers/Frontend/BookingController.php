<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Customer\CustomerRequest;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\FoodRepository;
use App\Repositories\Eloquent\RoomRepository;
use App\Services\CustomerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends FrontendController
{
    protected $repository;
    protected $roomRepository;
    protected $foodRepository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(CustomerRepository::class);
        $this->roomRepository = app(RoomRepository::class);
        $this->foodRepository = app(FoodRepository::class);
        $this->service = app(CustomerService::class);
    }

    public function index()
    {
//        return Inertia::render('Web/Home/Index');
    }

    public function create()
    {

    }

    public function filterRoom(Request $request)
    {
        $params = $request->all();

        $record = $this->roomRepository->getListFilterRoom(data_get($params, 'room'));

        $checkIn = Carbon::createFromFormat('Y-m-d', data_get($params, 'check_in'));
        $checkOut = Carbon::createFromFormat('Y-m-d', data_get($params, 'check_out'));

        return Inertia::render('Web/Booking/RoomAvailable', [
            'rooms' => $record,
            'info_booking' => [
                'time_check_in' => data_get($params, 'check_in'),
                'time_check_out' => data_get($params, 'check_out'),
                'time_stay' => $checkIn->diffInDays($checkOut),
            ],
        ]);
    }

    public function bookFood(Request $request)
    {
        $params = $request->all();
        $record = $this->roomRepository->getListSelectRoom(data_get($params, 'rooms'));
        $foods = $this->foodRepository->get();

        return Inertia::render('Web/Booking/BookingFood', [
            'foods' => $foods->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'price' => $value->price,
                    'description' => $value->description,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            'info_booking' => $params,
            'select_rooms' => $record,
        ]);
    }

    public function confirm(Request $request)
    {
        $params = $request->all();
        $record = $this->roomRepository->getListSelectRoom(data_get(data_get($params, 'info_booking'),'rooms'));
//        dd($params, $record);
        return Inertia::render('Web/Booking/Confirm', [
            'info_booking' => $params,
            'select_rooms' => $record,
        ]);
    }

    public function payment(Request $request)
    {
        $params = $request->all();

        return Inertia::render('Web/Booking/Payment', [
            'info_booking' => $params,
        ]);
    }

    public function edit($id)
    {

    }
}
