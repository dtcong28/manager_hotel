<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Eloquent\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PermissionsController extends BackendController
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(PermissionRepository::class);
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

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
