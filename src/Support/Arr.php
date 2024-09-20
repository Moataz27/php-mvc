<?php

namespace Mvc\Support;

use ArrayAccess;

class Arr
{
    public static function only(array $array, array|string $keys)
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }

    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function exists(array|ArrayAccess $array, string $key): bool
    {
        if ($array instanceof ArrayAccess)
            $array->offsetExists($key);

        return array_key_exists($key, $array);
    }

    public static function has(array $array, array|string $keys): bool
    {
        $keys = (array) $keys;

        foreach ($keys as $key) {
            $subArray = $array;

            if (static::exists($array, $key))
                continue;

            foreach (explode('.', $key) as $segment) {
                if (self::accessible($subArray) && self::exists($subArray, $segment))
                    $subArray = $subArray[$segment];
                else
                    return false;
            }
        }

        return true;
    }

    public static function last(array $array, callable $callback = null, $default = null)
    {
        if (is_null($callback))
            return empty($array) ? value($default) : end($array);

        return static::first(array_reverse($array, true), $callback, $default);
    }

    public static function first(array $array, callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($array)) return value($default);

            foreach ($array as $item)
                return $item;
        }

        foreach ($array as $key => $value)
            if (call_user_func($callback, $value, $key))
                return $value;

        return value($default);
    }

    public static function forget(&$array, array|string $keys)
    {
        $original = &$array;

        $keys = (array) $keys;

        if (empty($keys))
            return;

        foreach ($keys as $key) {
            if (static::exists($array, $key)) {
                unset($array[$key]);
                continue;
            }
            $segments = explode('.', $key);

            $array = &$original;

            while (count($segments) > 1) {
                $segment = array_shift($segments);
                if (self::accessible($array[$segment]) && self::exists($array, $segment)) {
                    $array = &$array[$segment];
                } else
                    continue;
            }
            
            unset($array[array_pop($segments)]);
        }
    }
}
