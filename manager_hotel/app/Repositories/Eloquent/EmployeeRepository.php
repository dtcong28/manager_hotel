<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;

class EmployeeRepository extends CustomRepository
{
    protected $model = Employee::class;

    public function __construct()
    {
        parent::__construct();
    }
}
