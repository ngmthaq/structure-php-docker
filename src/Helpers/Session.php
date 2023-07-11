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
}
