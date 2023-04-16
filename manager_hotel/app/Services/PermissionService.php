<?php

namespace App\Services;

use App\Repositories\Eloquent\PermissionRepository;

class PermissionService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(PermissionRepository::class));
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
        $data['name'] = strtolower($data['name']);
    }

    protected function prepareBeforeUpdate(&$data)
    {
        $data['name'] = strtolower($data['name']);
    }
}
