<?php

use Dotenv\Dotenv;
use Mvc\Validation\Validator;

require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'routes/web.php';

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();

$validator = new Validator;

$validator->setRules([
    'username' => 'required|alnum',
]);

$validator->setAliases(['username'  => 'name']);

$validator->make(['username' => '']);


dump($validator->errors());
