<?php

namespace Mvc\Database\Grammers;

use App\Models\Model;

class MySQLGrammer
{

    public static function buildInsertQuery($keys)
    {
        $query = 'INSERT INTO ' . Model::getTableName() . ' (`' . implode('`, `', $keys) . '`) VALUES(' . implode(', ', array_map(fn($k) => str_replace($k, '?', $k), $keys)) . ')';
        return $query;
    }

    public static function buildSelectQuery($columns, $filters)
    {
        $columns = is_array($columns) ? implode(', ', $columns) : $columns;
        $query = 'SELECT ' . $columns . ' FROM ' . Model::getTableName();
        if ($filters)
            $query .= ' WHERE ' . $filters[0] . ' ' . $filters[1] . ' ?';

        return $query;
    }

    public static function buildDeleteQuery()
    {
        return 'DELETE FROM ' . Model::getTableName() . ' WHERE ID = ?';
    }
}
