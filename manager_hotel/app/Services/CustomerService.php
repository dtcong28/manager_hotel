<?php

namespace App\Services;

use App\Repositories\Eloquent\CustomerRepository;
use Illuminate\Support\Facades\Hash;

class CustomerService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(CustomerRepository::class));
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

        if (array_key_exists('password', $data)) {
            $data['password'] = Hash::make($data['password']);
        }
    }
}
