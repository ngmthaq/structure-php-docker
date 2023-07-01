<?php

namespace Src\Helpers;

class Dev
{
    /**
     * Print data in screen
     * 
     * @param mixed $data
     * @return void
     */
    public static function print(mixed $data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo "<br/>";
    }
}
