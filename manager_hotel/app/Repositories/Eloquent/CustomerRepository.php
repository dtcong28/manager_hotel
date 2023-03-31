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

    public function getSearchCustomer($params)
    {
        $query = $this->select()
            ->where('name', 'LIKE', '%' . $params . '%')
            ->orWhere('address', 'LIKE', '%' . $params . '%')
            ->orWhere('phone', 'LIKE', '%' . $params . '%')
            ->orWhere('email', 'LIKE', '%' . $params . '%')
            ->orWhere('identity_card', 'LIKE', '%' . $params . '%')
            ->orderBy('id', 'desc');

        return $query->paginate(getConfig('page_number'));
    }
}
