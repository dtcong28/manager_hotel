<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Customer\CustomerRequest;
use App\Repositories\Eloquent\CustomerRepository;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class HomeController extends FrontendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(CustomerRepository::class);
        $this->service = app(CustomerService::class);
    }

    public function index()
    {
        return Inertia::render('Web/Home/Index');
    }

    public function create()
    {

    }

    public function edit($id)
    {

    }
}