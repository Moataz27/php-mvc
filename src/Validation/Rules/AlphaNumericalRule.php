<?php

namespace Mvc\Validation\Rules;

use Mvc\Validation\Rules\Contract\Rule;

class AlphaNumericalRule implements Rule
{
    public function apply($field, $value, $data)
    {
        return preg_match('/^[a-zA-Z0-9]+/', $value);
    }

    public function __toString()
    {
        return '%s must be characters and numbers only';
    }
}
