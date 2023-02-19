<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;

class CustomerRepository extends CustomRepository
{
    protected $model = Customer::class;

    public function __construct()
    {
        parent::__construct();
    }
}
