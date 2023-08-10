<?php

namespace Src\Helpers;

final class Common
{
    /**
     * Get current url (full path)
     * 
     * @return string
     */
    public static function getCurrentUrl()
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}
