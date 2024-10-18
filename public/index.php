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
    'username'  => ['nullable', 'max:20'],
    'remarks'   => 'prohibited',
    'email'     => ['required', 'email'],
    'password'  => 'required|confirmed',
    'password_confirmation' => 'required',
]);

$validator->setAliases(['username'  => 'name']);

$validator->make([
    'username' => null,
    'email' => 'moataz@test',
    'password' => 'Moataz#102',
    'password_confirmation' => 'Moataz#102d'
]);

dd($validator->errors());
