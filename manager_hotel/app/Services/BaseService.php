<?php

namespace App\Services;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class BaseService
{
    /**
     * @var BaseRepository $repository
     */
    protected $repository;

    public function __construct()
    {
        //
    }

    /**
     * @param $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return BaseRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function index($params)
    {
        return $this->getRepository()->getListForIndex($params);
    }

    /**
     * Store data
     *
     * @param $params
     * @return bool
     */
    public function store($params)
    {
        try {
            $this->prepareBeforeStore($params);
            $data = $this->getRepository()->create(Arr::except($params, ['hasFile']));

            if (!empty($params['hasFile'])) {
                $this->uploadImage($data, $params['hasFile']);
            }

            return true;
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' Line : ' . $exception->getLine());
        }

        return false;
    }

    /**
     * Update data
     *
     * @param $id
     * @param $params
     * @return bool
     */
    public function update($id, $params)
    {
        try {
            $this->prepareBeforeUpdate($params);
            $data = $this->getRepository()->update($id, $params);

            if (!empty($params['hasFile'])) {
                $this->updateImage($data, $params['hasFile']);
            }

            return true;
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' Line : ' . $exception->getLine());
        }

        return false;
    }

    /**
     * Delete item
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $this->getRepository()->delete($id);
            return true;
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' Line : ' . $exception->getLine());
        }

        return false;
    }

    protected function uploadImage(&$params, $images)
    {
        foreach ($images as $image) {
            $params->addMedia($image)->toMediaCollection('images');
        }
    }

    protected function updateImage(&$params, $images)
    {
        $params->clearMediaCollection('images');
        foreach ($images as $image) {
            $params->addMedia($image)->toMediaCollection('images');
        }
    }

    protected function prepareBeforeStore(&$params)
    {
        //
    }

    protected function prepareBeforeUpdate(&$params)
    {
        //
    }
}
