<?php

namespace Src\Helpers;

final class DateTime
{
    /**
     * Get unix timestamp
     * 
     * @return int
     */
    public static function unixTimestamp()
    {
        return time();
    }
}
