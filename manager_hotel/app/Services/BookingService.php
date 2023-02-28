<?php

namespace App\Services;

use App\Repositories\Eloquent\BookingRepository;

class BookingService extends CustomService
{
    public function __construct()
    {
        parent::__construct();
        $this->setRepository(app(BookingRepository::class));
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
        $data['customer_id'] = $data['customer']['id'];
        $data['type_booking'] = $data['type_booking']['value'];
        $data['number_rooms'] = count($data['rooms']);
        unset($data['customer']);
        unset($data['rooms']);
    }
//
//    protected function prepareBeforeUpdate(&$data)
//    {
//    }
}
