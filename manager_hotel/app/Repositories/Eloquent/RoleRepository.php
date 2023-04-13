<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;

class RoleRepository extends CustomRepository
{
    protected $model = Role::class;

    public function __construct()
    {
        parent::__construct();
    }
}
