<?php

namespace Mvc\Database\Managers;

use App\Models\Model;
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

    /**
     * raw Mysql query
     * 
     * @param string $query
     * @param array $values
     * 
     * @return [type]
     */
    public function query(string $query, $values = [])
    {
        $stmt = self::$PDOInstance->prepare($query);

        for ($i = 1; $i <= count($values); $i++)
            $stmt->bindValue($i, $values[$i - 1]);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function read($columns = '*', $filters = null)
    {
        $query = MySQLGrammer::buildSelectQuery($columns, $filters);

        $stmt = self::$PDOInstance->prepare($query);

        if ($filters)
            $stmt->bindValue(1, $filters[2]);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Model::getModel());
    }

    public function create(array $data)
    {
        $query = MySQLGrammer::buildInsertQuery(array_keys($data));

        $stmt = self::$PDOInstance->prepare($query);

        for ($i = 1; $i <= count($values = array_values($data)); $i++)
            $stmt->bindValue($i, $values[$i - 1]);

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $query = MySQLGrammer::buildUpdateQuery(array_keys($data));

        $stmt = self::$PDOInstance->prepare($query);

        for ($i = 1; $i <= count($values = array_values($data)); $i++) {
            $stmt->bindValue($i, $values[$i - 1]);
            if ($i == count($values))
                $stmt->bindValue($i + 1, $id);
        }

        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = MySQLGrammer::buildDeleteQuery();

        $stmt = self::$PDOInstance->prepare($query);

        $stmt->bindValue(1, $id);

        return $stmt->execute();
    }
}
