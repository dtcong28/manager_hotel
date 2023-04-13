<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Eloquent\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RoleController extends BackendController
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(RoleRepository::class);
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
