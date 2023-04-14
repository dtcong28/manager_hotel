<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserRequestUpdate;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends BackendController
{
    protected $repository;
    protected $permissionRepository;
    protected $roleRepository;
    protected $service;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(UserRepository::class);
        $this->permissionRepository = app(PermissionRepository::class);
        $this->roleRepository = app(RoleRepository::class);
        $this->service = app(UserService::class);
    }

    public function index(Request $request)
    {
        $user = $this->repository->get();
        return Inertia::render('Admin/User/Index',[
            'users' => $user
        ]);
    }

    public function create()
    {
        $permissions = $this->permissionRepository->get();
        $roles = $this->roleRepository->get();

        return Inertia::render('Admin/User/Create',[
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $user = $this->repository->create($params);
            if (empty($user)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                return Redirect::route('users.index');
            }

            if($request->has('roles')){
                if(!$user->syncRoles($request->input('roles.*.name'))){
                    DB::rollback();
                    session()->flash('action_failed', getConstant('messages.CREATE_FAIL'));

                    return Redirect::route('roles.index');
                }
            }

            if($request->has('permissions')){
                if(!$user->syncPermissions($request->input('permissions.*.name'))){
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

        return Redirect::route('users.index');
    }

    public function edit($id)
    {
        if (empty($id)) {
            return Redirect::route('users.index');
        }

        $record = $this->repository->find($id);
        $record->load('permissions');
        $record->load('roles');
        $permissions = $this->permissionRepository->get();
        $roles = $this->roleRepository->get();

        if (empty($record)) {
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

            return Redirect::route('users.index');
        }

        return Inertia::render('Admin/User/Edit', [
            'user' => $record,
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }

    public function update(UserRequestUpdate $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            $user = $this->repository->find($id);

            if (empty($id) || empty($params)) {
                return Redirect::route('users.index');
            }

            if (!$this->service->update($id, $params)) {
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('users.index');
            }

            if(!$user->syncRoles($request->input('roles.*.name'))){
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('users.index');
            }

            if(!$user->syncPermissions($request->input('permissions.*.name'))){
                DB::rollback();
                session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));

                return Redirect::route('users.index');
            }

            DB::commit();
            session()->flash('action_success', getConstant('messages.UPDATE_SUCCESS'));
        } catch (\Exception $exception) {
            DB::rollback();
            Log::error($exception);
            session()->flash('action_failed', getConstant('messages.UPDATE_FAIL'));
        }

        return back();
    }
}
