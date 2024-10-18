<?php

namespace Mvc\Validation\Rules;

use Mvc\Validation\Rules\Contract\Rule;

class NullableRule implements Rule
{
    public function apply($field, $value, $data)
    {
        return $value || is_null($value);
    }

    public function __toString()
    {
        return '%s can be null';
    }
}
