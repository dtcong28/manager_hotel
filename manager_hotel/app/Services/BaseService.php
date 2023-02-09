<?php

namespace App\Services;

use App\Repositories\Eloquent\BaseRepository;

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
            $this->getRepository()->create($params);
            return true;
        } catch (\Exception $exception) {
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
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
            $this->getRepository()->update($id, $params);

            return true;
        } catch (\Exception $exception) {
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
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
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
        }

        return false;
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
