<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Role\RoleRequest;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoleController extends BackendController
{
    protected $repository;
    protected $service;
    protected $permissionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(RoleRepository::class);
        $this->service = app(RoleService::class);
        $this->permissionRepository = app(PermissionRepository::class);
    }

    public function index(Request $request)
    {
        $roles = $this->repository->get();

        return Inertia::render('Admin/Role/Index',[
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = $this->permissionRepository->get();

        return Inertia::render('Admin/Role/Create',[
            'permissions' => $permissions,
        ]);
    }

    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $params['name'] = strtolower($params['name']);

            $role = $this->repository->create($params);

            if (empty($role)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('roles.index');
            }

            if($request->has('permissions')){
                if(!$role->syncPermissions($request->input('permissions.*.name'))){
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('roles.index');
                }
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.CREATE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));
        }

        return Redirect::route('roles.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('roles.index');
        }

        $record = $this->repository->find($id);
        $record->load('permissions');
        $permissions = $this->permissionRepository->get();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('roles.index');
        }

        return Inertia::render('Admin/Role/Edit', [
            'role' => $record,
            'permissions' => $permissions,
        ]);
    }

    public function update(RoleRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $role = $this->repository->find($id);

            if (empty($role) || empty($params)) {
                return Redirect::route('roles.index');
            }

            if (!$this->service->update($id, $params)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('roles.index');
            }

            if(!$role->syncPermissions($request->input('permissions.*.name'))){
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('roles.index');
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return Redirect::route('roles.index');
    }
}
