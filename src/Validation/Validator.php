<?php

namespace Mvc\Validation;

use Mvc\Support\Arr;
use Mvc\Validation\Rules\MaxRule;
use Mvc\Validation\Rules\RequiredRule;
use Mvc\Validation\Rules\Contract\Rule;
use Mvc\Validation\Rules\AlphaNumericalRule;
use Mvc\Validation\Rules\BetweenRule;

/** 
 * [new RuleClass, new AnotherRuleClass],
 * ['required', 'alnum']
 * 'required|alnum'
 */
class Validator
{
    protected array $data = [];
    protected array $aliases = [];
    protected array $rules = [];
    protected ErrorBag $errorBag;
    protected array $ruleMap = [
        'required'  => RequiredRule::class,
        'alnum'     => AlphaNumericalRule::class,
        'max'       => MaxRule::class,
        'between'   => BetweenRule::class,
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
        $rules = is_string($rules) ? $this->resolveStringRule($rules) : $rules;

        return array_map(function ($rule) {
            return is_string($rule) ? $this->mapRuleFromString($rule) : $rule;
        }, $rules);
    }

    protected function resolveStringRule(string $rule, string $seperator = '|'): array
    {
        return explode($seperator, $rule);
    }

    protected function mapRuleFromString(string $rule): Rule
    {
        $exploded = $this->resolveStringRule($rule, ':');
        $rule = Arr::first($exploded);
        $options = explode(',' ,Arr::last($exploded));

        return new $this->ruleMap[$rule](...$options);
    }

    protected function applyRule(string $field, Rule $rule)
    {
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
