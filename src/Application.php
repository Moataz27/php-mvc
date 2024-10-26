<?php

namespace Mvc;

use Mvc\Database\DB;
use Mvc\Database\Managers\MySQLManager;
use Mvc\Http\Request;
use Mvc\Http\Response;
use Mvc\Http\Route;
use Mvc\Support\Config;
use Mvc\Support\Session;

class Application
{
    protected Route $route;

    protected Request $request;

    protected Response $response;

    protected Config $config;

    protected DB $db;

    protected Session $session;

    public function __construct()
    {
        $this->request = new Request;
        $this->response = new Response;
        $this->session = new Session;
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfigurations());
        $this->db = new DB($this->getDatabaseDriver());
    }

    protected function getDatabaseDriver()
    {
        return match (env('DB_DRIVER')) {
            'mysql' => new MySQLManager,
            default => new MySQLManager,
        };
    }

    public function run()
    {
        $this->db->init();
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
