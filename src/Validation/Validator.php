<?php

namespace Mvc\Validation;

use Mvc\Validation\Rules\AlphaNumericalRule;
use Mvc\Validation\Rules\Contract\Rule;
use Mvc\Validation\Rules\RequiredRule;

class Validator
{
    protected array $data = [];
    protected array $aliases = [];
    protected array $rules = [];
    protected ErrorBag $errorBag;
    protected array $ruleMap = [
        'required'  =>  RequiredRule::class,
        'alnum'     =>  AlphaNumericalRule::class,
    ];

    public function make(array $data)
    {
        $this->data = $data;
        $this->errorBag = new ErrorBag;
        $this->validate();
    }

    protected function validate()
    {
        foreach ($this->rules as $field => $rules) {
            foreach ($this->resolveRules($rules) as $rule) {
                $this->applyRule($field, $rule);
            }
        }
    }

    protected function resolveRules(string|array $rules): array
    {
        if (is_string($rules)) {
            $rules = str_contains($rules, '|') ? explode('|', $rules) : [$rules];
        }
        return $rules;
    }

    protected function applyRule(string $field, Rule|string $rule)
    {
        if (is_string($rule))
            $rule = new $this->ruleMap[$rule];

        if (!$rule->apply($field, $this->getFieldValue($field), $this->data))
            $this->errorBag->add($field, Message::generate($rule, $this->alias($field)));
    }

    protected function getFieldValue(string $field)
    {
        return $this->data[$field] ?? null;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function passes()
    {
        return empty($this->errors);
    }

    public function errors($key = null)
    {
        return $key ? $this->errorBag->errors[$key] : $this->errorBag->errors;
    }

    public function alias(string $field)
    {
        return $this->aliases[$field] ?? $field;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
}
