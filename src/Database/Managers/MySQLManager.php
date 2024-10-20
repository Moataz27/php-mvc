<?php

namespace Mvc\Database\Managers;

use Mvc\Database\Grammers\MySQLGrammer;
use Mvc\Database\Managers\Contracts\DatabaseManager;
use PDO;

class MySQLManager implements DatabaseManager
{

    protected static $PDOInstance;

    public function connect(): PDO
    {
        if (!static::$PDOInstance)
            static::$PDOInstance = new PDO(
                config('database.driver') . ':host=' . config('database.host') . ';dbname=' . config('database.db'),
                config('database.username'),
                config('database.passowrd'),
            );

        return static::$PDOInstance;
    }

    public function query(string $query, $values = []) {}

    public function read($columns = '*', $filters = null) {}

    public function create(array $data)
    {
        $query = MySQLGrammer::buildInsertQuery(array_keys($data));

        $stmt = self::$PDOInstance->prepare($query);
    }

    public function update($id, $data) {}

    public function delete($id) {}
}
