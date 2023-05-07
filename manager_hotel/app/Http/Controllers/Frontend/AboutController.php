<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\FoodRepository;
use App\Repositories\Eloquent\HotelRepository;
use App\Repositories\Eloquent\RoomRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends FrontendController
{
    protected $roomRepository;
    protected $userRepository;
    protected $customerRepository;
    protected $foodRepository;

    public function __construct()
    {
        parent::__construct();
        $this->roomRepository = app(RoomRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->customerRepository = app(CustomerRepository::class);
        $this->foodRepository = app(FoodRepository::class);
    }

    public function index()
    {
        return Inertia::render('Web/About/Index', [
            'totalRooms' => $this->roomRepository->get()->count(),
            'totalEmployee' => $this->userRepository->get()->count(),
            'totalCustomer' => $this->customerRepository->get()->count(),
            'totalFood' => $this->foodRepository->get()->count(),
        ]);
    }

}
