<?php

namespace Src\Helpers;

class Session
{
    /**
     * Start session
     * 
     * @param string $name
     * @return void
     */
    public static function start(string $name = "PHPSESSID")
    {
        session_name($name);
        session_start();
    }

    /**
     * Set session data
     * 
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set(string $key, mixed $value)
    {
        $_SESSION[$key] = $value;
        return true;
    }

    /**
     * Get session data
     * 
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Delete session data
     * 
     * @param string $key
     * @return bool
     */
    public static function delete(string $key)
    {
        unset($_SESSION[$key]);
        return true;
    }

    /**
     * Set flash message
     * 
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function setFlashMessage(string $key, string $value)
    {
        $_SESSION[FLASH_MESSAGE_KEY][$key] = $value;
    }
}
