<?php

namespace Src\Helpers;

final class Dev
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
        if ($_ENV["APP_ENV"] !== "production") {
            $output = json_encode($output, JSON_HEX_TAG);
            $code = "console.$type($output);";
            $code = "<script>" . $code . "</script>";
            echo $code;
            echo PHP_EOL;
        }
    }

    public static function writeLog(string $message, string $file_name, string $status = LOG_STATUS_INFO)
    {
        $log_dir = Dir::getDirFromSrc("/Cached/Logs");
        if (!file_exists($log_dir)) mkdir($log_dir, 0777, true);
        $date = gmdate("Y_m_d");        // UTC
        $time = time();                 // Unix Timestamp
        $user = Cookies::get(AUTH_KEY) ?? "GUEST";
        if ($user !== "GUEST") {
            $auth = json_decode($user, true);
            $user = Hash::rowFenceDecrypt($auth["output"], $auth["key"]);
        }
        $uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : null;
        $uri = isset($uri) ? $uri : $_SERVER["SCRIPT_FILENAME"];
        $method = $_SERVER["REQUEST_METHOD"] ?? "NULL";
        $full_message = preg_replace('/\s+/S', " ", "[$time][$status][$user][$method][$uri]: $message");
        $full_file_name = "$file_name" . "_$date.log";
        $full_path = $log_dir . "/" . $full_file_name;
        file_put_contents($full_path, $full_message . "\n", FILE_APPEND | LOCK_EX);
    }
}
