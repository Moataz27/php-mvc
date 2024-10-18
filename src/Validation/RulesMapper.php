<?php

namespace Mvc\Validation;

use Mvc\Validation\Rules\MaxRule;
use Mvc\Validation\Rules\BetweenRule;
use Mvc\Validation\Rules\RequiredRule;
use Mvc\Validation\Rules\AlphaNumericalRule;
use Mvc\Validation\Rules\Contract\Rule;

trait RulesMapper
{
    protected static array $map = [
        'required'  => RequiredRule::class,
        'alnum'     => AlphaNumericalRule::class,
        'max'       => MaxRule::class,
        'between'   => BetweenRule::class,
    ];

    public static function resolve(string $rule, array $options): Rule
    {
        return new self::$map[$rule](...$options);
    }
}
