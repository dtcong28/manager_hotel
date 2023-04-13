<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class UserController extends BackendController
{
    protected $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = app(UserRepository::class);
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
