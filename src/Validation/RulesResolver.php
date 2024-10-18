<?php

namespace Mvc\Validation;

use Mvc\Validation\Rules\Contract\Rule;

trait RulesResolver
{
    public static function resolve(string|array $rules): array
    {
        $rules = is_string($rules) ? static::resolveStringRule($rules) : $rules;

        return array_map(function ($rule) {
            return is_string($rule) ? static::mapRuleFromString($rule) : $rule;
        }, $rules);
    }

    public static function resolveStringRule(string $rule, string $seperator = '|'): array
    {
        return explode($seperator, $rule);
    }

    public static function mapRuleFromString(string $rule): Rule
    {
        [$rule, $options] = static::resolveStringRule($rule, ':');
        return RulesMapper::resolve($rule, explode(',', $options));
    }
}
