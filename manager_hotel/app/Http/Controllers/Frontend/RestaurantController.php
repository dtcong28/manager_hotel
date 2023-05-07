<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Eloquent\FoodRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantController extends FrontendController
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(FoodRepository::class);
    }

    public function index(Request $request)
    {
        $foods = $this->repository->get();

        return Inertia::render('Web/Restaurant/Index', [
            'foods' => $foods->map(function ($value) {
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

}
