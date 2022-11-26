<?php

namespace App\Helper;

class StringHelper
{
    /**
     * @param $str
     * @return string|string[]|null
     */
    public static function snakeCase($str)
    {
        $str[0] = strtolower($str[0]);
        return preg_replace_callback('/([A-Z])/', function($c) {
            return "_" . strtolower($c[1]);
        }, $str);
    }

    /**
     * @param $string
     * @param false $UpperCase
     * @return string|string[]
     */
    public static function camelCase($string, $UpperCase = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        if (!$UpperCase) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }

    /**
     * @param $origin
     * @param $key
     * @param string $default
     * @return string
     */
    public static function getString($origin, $key, string $default = ""): string
    {
        switch (gettype($origin)) {
            case 'array':
                return !empty($origin[$key]) ? $origin[$key] : $default;
            case 'object':
                return !empty($origin->$key) ? $origin->$key : $default;
            case 'integer':
            case 'double':
                return (string)$origin;
            case 'string':
                return $origin;
            default:
                return $default;
        }
    }

    /**
     * @param object|array $key
     * @param string $default
     * @return string
     */
    public static function getHeader(string $key, string $default = ""): string
    {
        return StringHelper::getString($_SERVER, $key, $default);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function parseBool(string $key): bool {
        return filter_var($key, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param $haystack
     * @param $needle
     * @param bool $insensitive
     * @return bool
     */
    public static function hasString($haystack, $needle, bool $insensitive = false): bool
    {
        if ($insensitive) {
            return stripos($haystack, $needle) !== false;
        }
        return strpos($haystack, $needle) !== false;
    }
}
