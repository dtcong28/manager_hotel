<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Customer\CustomerRequest;
use App\Repositories\Eloquent\CustomerRepository;
use App\Services\CustomerService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends BackendController
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
        $params = request()->all();
        $record = $this->service->index($params);

        foreach (\App\Models\Enums\GenderEnum::cases() as $key => $data) {
            $gender[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $record,
            'gender' => $gender,
        ]);
    }

    public function create()
    {
        foreach (\App\Models\Enums\GenderEnum::cases() as $key => $data) {
            $gender[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Customers/Create', [
            'gender' => $gender,
        ]);
    }

    public function store(CustomerRequest $request)
    {
        try {
            $params = $request->all();

            if ($this->service->store($params)) {
                session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
            } else {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('customers.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('customers.index');
        }

        $record = $this->repository->find($id)->toArray();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('customers.index');
        }

        foreach (\App\Models\Enums\GenderEnum::cases() as $key => $data) {
            $gender[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Customers/Edit', [
            'customer' => $record,
            'gender' => $gender,
        ]);
    }

    public function update(CustomerRequest $request, $id)
    {
        try {
            if (empty($id) || empty($request)) {
                return Redirect::route('customers.index');
            }

            $params = $request->all();

            if ($this->service->update($id, $params)) {
                session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
            } else {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('customers.index');
    }
}
