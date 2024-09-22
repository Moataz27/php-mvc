<?php

use Dotenv\Dotenv;
use Mvc\Support\Arr;
use Mvc\Support\Config;

require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'routes/web.php';

$env = Dotenv::createImmutable(base_path());

$env->load();

app()->run();

$arr = [
    'db' => [
        'connections' => [
            'default' => 'mysql',
            'secondary' => 'sqlite',
            'tests' => [
                'test 1',
                'test 2',
            ]
        ],
        'fetch' => [
            'mode' => 'FETCH_ASSOC',
            'unicode' => 'UTF_8',
        ]
    ],
    'username' => 'moataz',
];

$config = new Config($arr);

dump($config->get(['db.connections.default', 'db.fetch']));
// dump(Arr::except($arr, ['username', 'db.connections.tests']));

// dump(Arr::get($arr, 'db.connections'));
// dump(Arr::flatten($arr));
// Arr::forget($arr, 'db.connections');
// var_dump(Arr::except($arr ,['username']));
