<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\FeedBackRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\FoodRepository;
use App\Repositories\Eloquent\RoomRepository;
use Inertia\Inertia;

class HomeController extends FrontendController
{
    protected $roomRepository;
    protected $userRepository;
    protected $customerRepository;
    protected $foodRepository;
    protected $feedBackRepository;

    public function __construct()
    {
        parent::__construct();
        $this->roomRepository = app(RoomRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->customerRepository = app(CustomerRepository::class);
        $this->foodRepository = app(FoodRepository::class);
        $this->feedBackRepository = app(FeedBackRepository::class);
    }

    public function index()
    {
        $record = $this->roomRepository->paginate(6);

        return Inertia::render('Web/Home/Index', [
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
            'totalRooms' => $this->roomRepository->get()->count(),
            'totalEmployee' => $this->userRepository->get()->count(),
            'totalCustomer' => $this->customerRepository->get()->count(),
            'totalFood' => $this->foodRepository->get()->count(),
            'feedBack' => $this->feedBackRepository->getFeedBack(),
        ]);
    }
}
