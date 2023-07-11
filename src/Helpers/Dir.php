<?php

namespace Src\Helpers;

final class Dir
{
    /**
     * Get root directory
     * 
     * @return string
     */
    public static function getRootDir()
    {
        $unix_path = str_replace("\\", "/", __DIR__);
        $root_path = str_replace("/src/Helpers", "", $unix_path);
        return $root_path;
    }

    /**
     * Get workspace directory
     * 
     * @return string
     */
    public static function getWorkspaceDir()
    {
        return self::getRootDir();
    }

    /**
     * Get public directory
     * 
     * @return string
     */
    public static function getPublicDir()
    {
        return self::getWorkspaceDir() . "/public";
    }


    /**
     * Get src directory
     * 
     * @return string
     */
    public static function getSrcDir()
    {
        return self::getWorkspaceDir() . "/src";
    }

    /**
     * Get dir path from src folder
     * 
     * @param string $path
     * @return string
     */
    public static function getDirFromSrc(string $path)
    {
        return self::getSrcDir() . $path;
    }

    /**
     * Get assets
     * 
     * @param string $path
     * @return string
     */
    public static function assets(string $path)
    {
        return "/" . $path . "?t=" . time();
    }
}
