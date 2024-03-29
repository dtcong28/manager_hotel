<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Eloquent\FeedBackRepository;
use App\Services\FeedBackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('feed-back.index');
        }

        $record = $this->repository->with('customer')->find($id);

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('feed-back.index');
        }

        return Inertia::render('Admin/FeedBack/Edit', [
            'feedBack' => $record
        ]);
    }

    public function update(Request $request)
    {
        $params = $request->all();
        $this->service->update($params['id'], ['active' => $params['status']]);

        return response()->json(['message' => getConstant('messages.UPDATE_SUCCESS')]);
    }
}
