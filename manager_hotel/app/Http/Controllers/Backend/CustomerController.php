<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Customer\CustomerRequest;
use App\Repositories\Eloquent\BookingFoodRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Services\BookingFoodService;
use App\Services\BookingService;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CustomerController extends BackendController
{
    protected $repository;
    protected $bookingRepository;
    protected $bookingFoodRepository;
    protected $service;
    protected $bookingService;
    protected $bookingFoodService;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(CustomerRepository::class);
        $this->bookingRepository = app(BookingRepository::class);
        $this->bookingFoodRepository = app(BookingFoodRepository::class);
        $this->service = app(CustomerService::class);
        $this->bookingService = app(BookingService::class);
        $this->bookingFoodService = app(BookingFoodService::class);
    }

    public function index(Request $request)
    {
        $record = $this->repository->getSearchCustomer($request->search);

        return Inertia::render('Admin/Customers/Index', [
            'customers' => $record,
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

            if (!($this->service->store($params))) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));;
                return Redirect::route('customers.index');
            }

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
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

            if (!($this->service->update($id, $params))) {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('customers.index');
            };

            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('customers.index');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $customer = $this->repository->find($id);

            if (empty($customer)) {
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            $booked = $customer->booking()->get();
            foreach ($booked as $value)
            {
                $bookRoom = $value->bookingRoom()->get();
                $bookFood = $value->bookingFood()->get();
                if($bookRoom->isNotEmpty() && !$value->bookingRoom()->delete()  ) {
                    session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
                    DB::rollback();
                    return redirect(getBackUrl());
                }
                //neu phong da duoc khach check in => cap nhat tinh trang phong la trong

                if($bookFood->isNotEmpty() && !$value->bookingFood()->delete()) {
                    session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
                    DB::rollback();
                    return redirect(getBackUrl());
                }
            }

            if($booked->isNotEmpty() && !$customer->booking()->delete()){
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
                DB::rollback();
                return redirect(getBackUrl());
            }

            if(!($customer->delete())){
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));

                return redirect(getBackUrl());
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.DELETE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.DELETE_FAIL'));
        }

        return redirect(getBackUrl());
    }
}
