<?php

namespace Src\Helpers;

class Header
{
    /**
     * Get full url
     * 
     * @return string
     */
    public static function getFullUrl()
    {
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
}
