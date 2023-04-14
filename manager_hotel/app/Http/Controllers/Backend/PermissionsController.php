<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Permission\PermissionRequest;
use App\Repositories\Eloquent\PermissionRepository;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PermissionsController extends BackendController
{
    protected $repository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(PermissionRepository::class);
        $this->service = app(PermissionService::class);
    }

    public function index(Request $request)
    {
        $permission = $this->repository->get();
        return Inertia::render('Admin/Permissions/Index',[
            'permissions' => $permission
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Permissions/Create');
    }

    public function store(PermissionRequest $request)
    {
        try {
            $params = $request->all();

            if (!$this->service->store($params)) {
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('permissions.index');
            }

            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('permissions.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('permissions.index');
        }

        $record = $this->repository->find($id)->toArray();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('permissions.index');
        }

        return Inertia::render('Admin/Permissions/Edit', [
            'permission' => $record
        ]);
    }

    public function update(PermissionRequest $request, $id)
    {
        $params = $request->all();

        try {
            if (empty($id) || empty($params)) {
                return Redirect::route('permissions.index');
            }

            if (!$this->service->update($id, $params)) {
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('permissions.index');
            }

            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('permissions.index');
    }
}
