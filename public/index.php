<?php

use Dotenv\Dotenv;
use Mvc\Http\Route;
use Mvc\Http\Request;
use Mvc\Http\Response;

require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'routes/web.php';

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();
