<?php

use Mvc\Application;
use Mvc\Http\Request;
use Mvc\Http\Response;
use Mvc\Support\Hash;
use Mvc\View\View;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return $_ENV[$key] ?? value($default);
    }
}

if (!function_exists('app')) {
    function app()
    {
        static $instance = null;

        if (!$instance) {
            $instance = new Application();
        }

        return $instance;
    }
}

if (!function_exists('value')) {
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('base_path')) {
    function base_path()
    {
        return dirname(__DIR__) . '/../';
    }
}

if (!function_exists('view_path')) {
    function view_path()
    {
        return base_path() . 'views/';
    }
}

if (!function_exists('view')) {
    function view($view, $params = [])
    {
        View::make($view, $params);
    }
}

if (!function_exists('config_path')) {
    function config_path()
    {
        return base_path() . 'config/';
    }
}

if (!function_exists('config')) {
    function config(string|array $key = null, mixed $default = null)
    {
        if (is_null($key)) {
            return app()->config;
        }
        if (is_array($key)) {
            return app()->config->set($key);
        }

        return app()->config->get($key, $default);
    }
}

if (!function_exists('bcrypt')) {
    function bcrypt(string $password)
    {
        return Hash::password($password);
    }
}

if (!function_exists('class_basename')) {
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('old')) {
    function old(string $key)
    {
        if (app()->session->hasFlash('old'))
            return app()->session->getFlash('old')[$key];
    }
}

if (!function_exists('request')) {
    function request(string|array $key = null)
    {
        $request = new Request;

        if ($key)
            return $request->get($key);

        if (is_array($key))
            return $request->only($key);

        return $request;
    }
}

if (!function_exists('back')) {
    function back()
    {
        return (new Response)->back();
    }
}
