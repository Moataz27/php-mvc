<?php

use Dotenv\Dotenv;
use Mvc\Validation\Rules\AlphaNumericalRule;
use Mvc\Validation\Rules\RequiredRule;
use Mvc\Validation\Validator;

require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'routes/web.php';

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();

$validator = new Validator;

$validator->setRules([
    'username'  => 'required|alnum',
    'email'     => ['required', 'alnum'],
    'test'      => [new RequiredRule, new AlphaNumericalRule],
]);

$validator->setAliases(['username'  => 'name']);

$validator->make(['username' => '']);


dump($validator->errors());
