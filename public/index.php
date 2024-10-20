<?php

use Dotenv\Dotenv;
use Mvc\Database\Grammers\MySQLGrammer;

require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'routes/web.php';

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();

dd(MySQLGrammer::buildSelectQuery(['username', 'full_name', 'id', 'email'], ['username', 'LIKE', '%moataz%']));
