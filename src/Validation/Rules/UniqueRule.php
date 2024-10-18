<?php

namespace Mvc\Validation\Rules;

use Mvc\Validation\Rules\Contract\Rule;

class UniqueRule implements Rule
{
    protected string $table;

    protected string $column;

    protected string $except;

    public function __construct(string $table, string $column, int $except)
    {
        $this->table = $table;
        $this->column = $column;
        $this->except = $except;
    }

    public function apply($field, $value, $data)
    {
        // TODO -- Select count(id) where column = value and id != $except
    }

    public function __toString()
    {
        return '%s is already taken';
    }
}
