<?php

namespace Mvc\Validation\Rules;

use Mvc\Validation\Rules\Contract\Rule;

class UniqueRule implements Rule
{
    protected string $table;

    protected string $column;

    protected ?int $except;

    public function __construct(string $table, string $column, ?int $except = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->except = $except;
    }

    public function apply($field, $value, $data)
    {
        $query = 'SELECT COUNT(ID) FROM ' . $this->table . " WHERE $this->column = ?";
        $params[] = $value;
        if (!is_null($this->except)) {
            $query .= ' AND ID <> ?';
            $params[] = $this->except;
        }
        $count = app()->db->raw($query, $params)[0]['COUNT(ID)'];

        return $count === 0;
    }

    public function __toString()
    {
        return '%s is already taken';
    }
}
