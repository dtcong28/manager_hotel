<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\FeedBack\FeedBackRequest;
use App\Repositories\Eloquent\HotelRepository;
use App\Services\FeedBackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ContactController extends FrontendController
{
    protected $hotelRepository;
    protected $feedBackService;

    public function __construct()
    {
        parent::__construct();
        $this->hotelRepository = app(HotelRepository::class);
        $this->feedBackService = app(FeedBackService::class);
    }

    public function index()
    {
        return Inertia::render('Web/Contact/Index');
    }

    public function feedBack(FeedBackRequest $request){
        try {
            $params = $request->all();
            $params['customer_id'] = auth('web')->user()->id;

            if (!$this->feedBackService->store($params)) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('web.contact.index');
            }

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('web.contact.index');
    }
}
