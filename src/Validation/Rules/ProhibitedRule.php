<?php

namespace Mvc\Validation\Rules;

use Mvc\Validation\Rules\Contract\Rule;

class ProhibitedRule implements Rule
{
    public function apply($field, $value, $data)
    {
        return !array_key_exists($field, $data);
    }

    public function __toString()
    {
        return '%s is prohibited';
    }
}
