<?php

namespace Mvc\Validation\Rules;

use Mvc\Validation\Rules\Contract\Rule;

class BetweenRule implements Rule
{
    protected int $min;

    protected int $max;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function apply($field, $value, $data)
    {
        return strlen($value) >= $this->min && strlen($value) <= $this->max;
    }

    public function __toString()
    {
        return "%s must be between {$this->min} and {$this->max}";
    }
}
