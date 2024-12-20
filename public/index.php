<?php

use Dotenv\Dotenv;


require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'routes/web.php';

session_start();

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();
