<?php

namespace App\Services;

use App\Repositories\Eloquent\EmployeeRepository;
use Illuminate\Support\Facades\Hash;

class EmployeeService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(EmployeeRepository::class));
    }

    public function store($params)
    {
        return parent::store($params);
    }

    public function update($id, $params)
    {
        return parent::update($id, $params);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    protected function prepareBeforeStore(&$data)
    {
        $this->prepareSave($data);
    }

    protected function prepareBeforeUpdate(&$data)
    {
        $this->prepareSave($data);
    }

    protected function prepareSave(&$data)
    {
        $data['gender'] = $data['gender']['value'];
        $data['password'] = Hash::make($data['password']);
    }
}
