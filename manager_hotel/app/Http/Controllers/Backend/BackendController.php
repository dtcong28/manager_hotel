<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class BackendController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    protected function getFormDataKey()
    {
        return getControllerName();
    }

    protected function setFormData($data)
    {
        session()->put([$this->getFormDataKey() => $data]);

        return $this;
    }

    protected function getFormData(bool $clean = false)
    {
        $data = session()->get($this->getFormDataKey(), []);

        if ($clean) {
            $this->cleanFormData();
        }

        return $data;
    }

    protected function cleanFormData()
    {
        session()->forget($this->getFormDataKey());
    }
}
