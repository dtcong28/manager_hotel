<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BackendController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {

    }

    protected $repository;
    protected $service;

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return redirect(getBackUrl());
            }

            if (empty($this->repository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            if (!$this->service->destroy($id)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return redirect(getBackUrl());
    }
}
