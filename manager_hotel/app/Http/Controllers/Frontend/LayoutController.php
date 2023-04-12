<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Eloquent\HotelRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LayoutController extends FrontendController
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(HotelRepository::class);

    }

    public function index()
    {
        return Inertia::render('Web/About/Index');
    }

}