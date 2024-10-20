<?php

namespace Mvc\Database\Concerns;

use Mvc\Database\Managers\Contracts\DatabaseManager;

trait ConnectsTo
{
    public static function connect(DatabaseManager $manager)
    {
        return $manager->connect();
    }
}
