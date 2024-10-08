<?php

namespace Mvc;

use Mvc\Http\Request;
use Mvc\Http\Response;
use Mvc\Http\Route;
use Mvc\Support\Config;

class Application
{
    protected Route $route;

    protected Request $request;

    protected Response $response;

    protected Config $config;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigurations());
    }

    public function run()
    {
        $this->route->resolve();
    }

    protected function loadConfigurations()
    {
        foreach (scandir(config_path()) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $fileName = explode('.', $file)[0];
            yield $fileName => require config_path() . $file;
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
