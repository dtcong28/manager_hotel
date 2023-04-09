<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Models\Enums\GenderEnum;

class EmployeeRepository extends CustomRepository
{
    protected $model = Employee::class;

    public function __construct()
    {
        parent::__construct();
    }

    public function getSearchEmployee($params){
        $query = $this->select()
            ->where('name', 'LIKE', '%' . $params . '%')
            ->orWhere('email', 'LIKE', '%' . $params . '%')
            ->orWhere('phone', 'LIKE', '%' . $params . '%')
            ->when(!empty($params), function ($q) use ($params) {
                foreach (GenderEnum::cases() as $data) {
                    if(str_contains(strtolower($data->name), strtolower($params))){
                        $q->orWhere('gender', '=', $data->value);
                    }
                }
            })
            ->orderBy('id','desc');

        return $query->paginate(getConfig('page_number'));
    }
}
