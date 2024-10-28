<?php

namespace Mvc\Http;

use Exception;
use Mvc\View\View;

/**
 * @property Request $request
 * @property Response $response
 * @property array $routes
 */
class Route
{
    protected const CONTROLLER_NAMESPACE = 'App\\Controllers\\';

    protected Request $request;

    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected static array $routes = [];

    public static function get(string $uri, callable|array|string $action)
    {
        self::$routes['get'][$uri] = $action;
    }

    public static function post(string $uri, callable|array|string $action)
    {
        self::$routes['post'][$uri] = $action;
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $action = self::$routes[$method][$path] ?? false;

        if (!array_key_exists($path, self::$routes[$method])) {
            $this->response->setStatusCode(404);
            View::makeError('404');
        }

        if (is_callable($action))
            call_user_func($action);

        if (is_array($action)) {
            $this->resolveMethod($action[0], $action[1]);
        }

        if (is_string($action)) {
            [$class, $method] = explode('@', $action);
            $class = self::CONTROLLER_NAMESPACE . $class;
            if (class_exists($class)) {
                $this->resolveMethod($class, $method);
            }
        }
    }

    protected function resolveMethod($class, string $method)
    {
        if (method_exists($class, $method))
            call_user_func_array([new $class, $method], []);
        else
            throw new Exception('Method Doesn\'t exists');
    }
}
