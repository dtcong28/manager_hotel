<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Booking\BEbookingFoodRequest;
use App\Http\Requests\Booking\BookingFoodRequest;
use App\Repositories\Eloquent\BookingFoodRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\FoodRepository;
use App\Services\BookingFoodService;
use App\Services\FoodService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingFoodController extends BackendController
{
    protected $repository;
    protected $foodRepository;
    protected $bookingRepository;
    protected $service;
    protected $foodService;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(BookingFoodRepository::class);
        $this->foodRepository = app(FoodRepository::class);
        $this->bookingRepository = app(BookingRepository::class);
        $this->service = app(BookingFoodService::class);
        $this->foodService = app(FoodService::class);
    }

    public function index()
    {
        return Inertia::render('Admin/BookingFood/Index');
    }

    public function create()
    {
        $foods = $this->foodRepository->get();

        return Inertia::render('Admin/BookingFood/Create',[
            'foods' => $foods->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'price' => $value->price,
                    'description' => $value->description,
                    'image' => ($value->getMedia('images'))[0]->getUrl(),
                ];
            }),
            'booking' => $this->bookingRepository->findByField('id', request()->route('id')),
            'booked_food' => $this->repository->findByField('booking_id', request()->route('id')),
        ]);
    }

    public function store(BEbookingFoodRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            if (empty($params)) {
                return Redirect::route('booking.index');
            }

            $this->bookingRepository->update($params['booking'],['note_booking_food' => $params['note_booking_food'], 'meal_time' => $params['meal_time']]);

            $bookedFood = $this->repository->findByField('booking_id', $params['booking']);
            foreach ($bookedFood as $value)
            {
                $this->service->destroy($value->id);
            }

            foreach ($params['select_food'] as $key=>$value)
            {
                if(!is_null($value))
                {
                    $data['food_id'] = $key;
                    $data['amount'] = $value;
                    $data['booking_id'] = $params['booking'];

                    $food = $this->foodRepository->find($key);
                    $data['price'] = $value*$food->price;

                    if(!$this->service->store($data))
                    {
                        DB::rollback();
                        session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                        return Redirect::route('booking.index');
                    }
                }
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('booking.index');
    }
}
