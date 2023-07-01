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

    /**
     * Print data in screen and die
     * 
     * @param mixed $data
     * @return void
     */
    public static function die(mixed $data)
    {
        self::print($data);
        die();
    }

    /**
     * Log data in devtools
     * 
     * @param mixed $output
     * @param string $type
     * @return void
     */
    public static function console(mixed $output, string $type = "log")
    {
        $output = json_encode($output, JSON_HEX_TAG);
        $code = "console.$type($output);";
        $code = "<script>" . $code . "</script>";
        echo $code;
        echo PHP_EOL;
    }
}
