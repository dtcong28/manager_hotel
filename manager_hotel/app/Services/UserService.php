<?php

namespace App\Services;

use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(UserRepository::class));
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
        $data['password'] = Hash::make($data['password']);
    }
//
//    protected function prepareBeforeUpdate(&$data)
//    {
//    }
}
