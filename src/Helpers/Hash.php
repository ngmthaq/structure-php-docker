<?php

namespace Src\Helpers;

class Hash
{
    /**
     * Hash a string using md5 function
     * 
     * @param string $plain
     * @return string
     */
    public static function make(string $plain)
    {
        return md5($plain);
    }

    /**
     * Compare plain text and hash text
     * 
     * @param string $plain
     * @param string $hashed
     * @return bool
     */
    public static function check(string $plain, string $hashed)
    {
        return self::make($plain) === $hashed;
    }
}
