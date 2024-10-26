<?php

namespace Mvc\Validation;

use Error;
use Mvc\Validation\Rules\MaxRule;
use Mvc\Validation\Rules\BetweenRule;
use Mvc\Validation\Rules\RequiredRule;
use Mvc\Validation\Rules\AlphaNumericalRule;
use Mvc\Validation\Rules\ConfirmedRule;
use Mvc\Validation\Rules\Contract\Rule;
use Mvc\Validation\Rules\EmailRule;
use Mvc\Validation\Rules\NullableRule;
use Mvc\Validation\Rules\ProhibitedRule;
use Mvc\Validation\Rules\UniqueRule;

trait RulesMapper
{
    // TODO --- Make class responsible for guessing name from class name, instead of add new validation every time
    protected static array $map = [
        'required'      => RequiredRule::class,
        'alnum'         => AlphaNumericalRule::class,
        'max'           => MaxRule::class,
        'between'       => BetweenRule::class,
        'email'         => EmailRule::class,
        'confirmed'     => ConfirmedRule::class,
        'prohibited'    => ProhibitedRule::class,
        'nullable'      => NullableRule::class,
        'unique'        => UniqueRule::class,
    ];

    public static function resolve(string $rule, array $options): Rule
    {
        if (array_key_exists($rule, self::$map)) {
            return new self::$map[$rule](...$options);
        }
        throw new Error("$rule not founded, must be a valid rule");
    }
}
