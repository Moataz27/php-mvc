<?php

namespace Mvc\Validation;

class ErrorBag
{
    protected array $errors = [];

    public function add(string $field, string $message)
    {
        $this->errors[$field][] = $message;
    }

    public function __get($key)
    {
        if (property_exists($this, $key))
            return $this->$key;
    }
}
