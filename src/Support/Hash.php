<?php

namespace Mvc\Support;
/**
 * @method password() @param strign $value @return string
 * @method verify() @param string $password @param string $hashedPassword @return bool
 * @method make() @param string $value @return string
 */
class Hash
{
    public static function password(string $value): string
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public static function verify(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public static function make(string $value): string
    {
        return sha1($value . time());
    }
}
