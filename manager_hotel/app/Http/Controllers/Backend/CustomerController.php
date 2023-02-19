<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Room\RoomRequest;
use App\Repositories\Eloquent\CustomerRepository;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends BackendController
{
    protected $customerRepository;
    protected $customerService;

    public function __construct(CustomerRepository $customerRepository, CustomerService $customerService)
    {
        parent::__construct();
        $this->customerRepository = $customerRepository;
        $this->customerService = $customerService;
    }

    public function index()
    {
        $params = request()->all();
        $record = $this->customerService->index($params);

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $record->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                    'address' => $value->address,
                    'gender' => $value->gender,
                    'phone' => $value->phone,
                    'email' => $value->email,
                    'identity_card' => $value->identity_card,
                ];
            }),
        ]);
    }

    public function create()
    {
        foreach (\App\Models\Enums\CustomerGenderEnum::cases() as $key => $data) {
            $gender[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Customers/Create', [
            'gender' => $gender,
        ]);
    }

    public function store(RoomRequest $request)
    {
        try {
            $params = $request->all();

            if ($this->customerService->store($params)) {
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

        $record = $this->customerRepository->find($id)->toArray();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('customers.index');
        }

        foreach (\App\Models\Enums\CustomerGenderEnum::cases() as $key => $data) {
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

    public function update(RoomRequest $request, $id)
    {
        try {
            if (empty($id) || empty($request)) {
                return Redirect::route('customers.index');
            }

            $params = $request->all();

            if ($this->customerService->update($id, $params)) {
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

    public function destroy($id)
    {
        try {
            if (empty($id)) {
                return Redirect::route('customers.index');
            }

            if (empty($this->customerRepository->find($id))) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('customers.index');
            }

            if (!$this->customerService->destroy($id)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return Redirect::route('customers.index');
            }

            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return Redirect::route('customers.index');
    }

}
