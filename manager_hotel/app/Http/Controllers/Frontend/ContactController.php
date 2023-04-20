<?php

namespace App\Http\Controllers\Frontend;

use App\Repositories\Eloquent\HotelRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends FrontendController
{
    protected $hotelRepository;
    public function __construct()
    {
        parent::__construct();
        $this->hotelRepository = app(HotelRepository::class);
    }

    public function index()
    {

        return Inertia::render('Web/Contact/Index');
    }

}
