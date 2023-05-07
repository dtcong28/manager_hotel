<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends CustomRepository
{
    protected $model = Permission::class;

    public function __construct()
    {
        parent::__construct();
    }
}
