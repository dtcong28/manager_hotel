<?php

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Core\Helpers\Url;

if (!function_exists('getConfig')) {
    /**
     * get config
     *
     * @param $key
     * @param null $default
     * @return Repository|Application|mixed
     */
    function getConfig($key, $default = null)
    {
        return config('config.' . $key, $default);
    }
}

if (!function_exists('getConstant')) {
    /**
     * get config constant
     *
     * @param $key
     * @param null $default
     * @return Repository|Application|mixed
     */
    function getConstant($key, $default = null)
    {
        return config('constant.' . $key, $default);
    }
}

if (!function_exists('getArea')) {
    /**
     * get current area
     * ex: batch, api, admin, web ...
     *
     * @return string|null
     */
    function getArea(): ?string
    {
        $area = 'web';

        if (App::runningInConsole()) {
            return 'batch';
        }

        $requestUri = request()->getRequestUri();
        $uri = explode('/', $requestUri);

        if (!array_key_exists(1, $uri)) {
            return $area;
        }

        $routePrefix = strtok($uri[1], '?');
        $config = getConfig('routes');

        foreach ($config as $key => $item) {
            if ($routePrefix == $item['prefix']) {
                $area = $key;
                break;
            }
        }

        return $area;
    }
}

if (!function_exists('getGuard')) {
    /**
     * @return Guard|StatefulGuard
     */
    function getGuard()
    {
        $area = getArea();
        $guards = config('auth.guards');
        $guards = !empty($guards) ? array_keys($guards) : [];

        if (!empty($guards) && in_array($area, $guards)) {
            return Auth::guard($area);
        }

        // return default if guard not setting or not found
        return Auth::guard();
    }
}

if (!function_exists('getRoute')) {
    /**
     * get route with area
     *
     * @param null $route
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function getRoute($route = null, $parameters = [], $absolute = true)
    {
        $area = getArea();
        $as = 'web.';
        $config = getConfig('routes');
        foreach ($config as $key => $item) {
            if ($area == $key) {
                $as = $item['as'];
                break;
            }
        }

        if (empty($route)) {
            return route($as . 'home', $parameters, $absolute);
        }

        return route($as . $route, $parameters, $absolute);
    }
}

if (!function_exists('getControllerName')) {
    /**
     * get controller name
     *
     * @return string|null
     */
    function getControllerName(): ?string
    {
        if (empty(Route::getCurrentRoute())) {
            return '';
        }
        $name = Route::getCurrentRoute()->getActionName();
        $controller = explode('@', class_basename($name));
        $controller = reset($controller);
        if (empty($controller)) {
            return '';
        }
        $controller = str_replace(['controller', 'Controller'], '', $controller);
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $controller));
    }
}

if (!function_exists('getActionName')) {
    /**
     * get method in controller
     *
     * @return string|null
     */
    function getActionName(): ?string
    {
        if (empty(Route::getCurrentRoute())) {
            return '';
        }
        $method = Route::getCurrentRoute()->getActionMethod();
        return strtolower(preg_replace('/([^A-Z])(A-Z)/', "$1_$2", $method));
    }
}

if (!function_exists('toSql')) {
    /**
     * @param $query
     * @return string
     */
    function toSql($query): string
    {
        return sqlBinding($query->toSql(), $query->getBindings());
    }
}

if (!function_exists('sqlBinding')) {
    /**
     * @param $sql
     * @param $bindings
     * @return string
     */
    function sqlBinding($sql, $bindings): string
    {
        $boundSql = str_replace(['%', '?'], ['%%', '%s'], $sql);

        foreach ($bindings as &$binding) {
            if ($binding instanceof \DateTime) {
                $binding = $binding->format('\'Y-m-d H:i:s\'');
            } elseif (is_string($binding)) {
                $binding = "'$binding'";
            }
        }

        return vsprintf($boundSql, $bindings);
    }
}

if (!function_exists('getTmpUploadDir')) {
    /**
     * get tmp upload dir
     *
     * @param $file
     * @return mixed
     */
    function getTmpUploadDir($file = null)
    {
        return getConfig('tmp_upload_dir', 'tmp_upload') . '/' . $file;
    }
}

if (!function_exists('is_json')) {
    /**
     * check is json string
     *
     * @param $string
     * @return bool
     */
    function is_json($string)
    {
        try {
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        } catch (\Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('getBackUrl')) {
    /**
     * @param bool $fromConfirm
     * @param bool $fullUrl
     * @return mixed|string
     */
    function getBackUrl(bool $fromConfirm = false, bool $fullUrl = true)
    {
        return $fromConfirm ? Url::getOldUrl() : Url::getBackUrl($fullUrl);
    }
}

