<?php

namespace App\Helper;

class Str
{
    /**
     * Convert string to camel case
     * @param string $str
     * @return string
     */
    public static function camelCase(string $str): string
    {
        $str = str_replace(['-', '_'], [' ', ' '], strtolower($str));

        $parts = array_values(array_filter(explode(" ", $str)));
        $first = array_shift($parts);

        return $first. implode('', array_map('ucfirst', $parts));
    }
}
