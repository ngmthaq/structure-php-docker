<?php

namespace Src\Helpers;

class Cookies
{
    /**
     * Set cookies
     * 
     * @param string $name
     * @param string $value
     * @param int $time
     * @return void
     */
    public static function set(string $name, string $value, int $time)
    {
        setcookie($name, $value, $time);
    }

    /**
     * Set cookies
     * 
     * @param string $name
     * @return void
     */
    public static function remove(string $name)
    {
        unset($_COOKIE[$name]);
        setcookie($name, "", -1);
    }

    /**
     * Get cookies
     * 
     * @param string $name
     * @return string|null
     */
    public static function get(string $name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }
}
