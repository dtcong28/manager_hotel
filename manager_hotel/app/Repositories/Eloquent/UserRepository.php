<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use Illuminate\Support\Facades\Session;

class UserRepository extends CustomRepository
{
    protected $model = User::class;

    public function __construct()
    {
        parent::__construct();
    }
}
