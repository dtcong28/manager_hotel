<?php

namespace App\Services;

use App\Repositories\Eloquent\FoodRepository;
use Illuminate\Support\Facades\Hash;

class FoodService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(FoodRepository::class));
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
        $images = $data['images'];

        if (!empty($images)) {
            $data['hasFile'] = $images;
            unset($data['images']);
        }
    }
}
