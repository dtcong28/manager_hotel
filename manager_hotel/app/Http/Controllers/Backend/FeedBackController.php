<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Eloquent\FeedBackRepository;
use App\Services\FeedBackService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedBackController extends BackendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(FeedBackRepository::class);
        $this->service = app(FeedBackService::class);
    }

    public function index(Request $request)
    {
        $record = $this->repository->getSearchFeedBack($request->search);

        return Inertia::render('Admin/FeedBack/Index', [
            'feedBack' => $record,
        ]);
    }
}
