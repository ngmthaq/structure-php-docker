<?php

namespace Src\Helpers;

final class Cookies
{
    /**
     * Set cookies
     * 
     * @param string $name
     * @param string $value
     * @param int $time
     * @return bool
     */
    public static function set(string $name, string $value, int $time = 0)
    {
        setcookie($name, $value, $time);
        return true;
    }

    /**
     * Set cookies
     * 
     * @param string $name
     * @return bool
     */
    public static function remove(string $name)
    {
        unset($_COOKIE[$name]);
        setcookie($name, "", -1);
        return true;
    }

    /**
     * Get cookies
     * 
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }
}
