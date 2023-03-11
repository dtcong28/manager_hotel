<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Eloquent\EmployeeRepository;
use App\Services\EmployeeService;
use App\Http\Requests\Employee\EmployeeRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EmployeeController extends BackendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(EmployeeRepository::class);
        $this->service = app(EmployeeService::class);;
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

        return Inertia::render('Admin/Employees/Index', [
            'employees' => $record,
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

        return Inertia::render('Admin/Employees/Create', [
            'gender' => $gender,
        ]);
    }

    public function store(EmployeeRequest $request)
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

        return Redirect::route('employees.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('employees.index');
        }

        $record = $this->repository->find($id)->toArray();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('employees.index');
        }

        foreach (\App\Models\Enums\GenderEnum::cases() as $key => $data) {
            $gender[$key] = [
                'value' => $data->value,
                'name' => $data->label(),
            ];
        }

        return Inertia::render('Admin/Employees/Edit', [
            'employee' => $record,
            'gender' => $gender,
        ]);
    }

    public function update(EmployeeRequest $request, $id)
    {
        try {
            if (empty($id) || empty($request)) {
                return Redirect::route('employees.index');
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

        return Redirect::route('employees.index');
    }
}
