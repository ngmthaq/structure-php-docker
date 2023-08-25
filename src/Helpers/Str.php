<?php

namespace Src\Helpers;

final class Str
{
    /**
     * Generate uuid
     * 
     * @return string
     */
    public static function uuid()
    {
        return vsprintf("%s%s-%s-%s-%s-%s%s%s", str_split(bin2hex(random_bytes(16)), 4));
    }

    /**
     * Generate random string
     * 
     * @param int $length random string length
     * @return string
     */
    public static function random(int $length = 10)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Check is email
     * 
     * @param string $email
     * @return bool
     */
    public static function isEmail(string $email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
