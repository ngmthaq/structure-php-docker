<?php

namespace Src\Helpers;

use Src\Locales\Vi;

class Lang
{
    /**
     * Register locales
     * 
     * @return array
     */
    public static function registerLocale()
    {
        return ["vi" => Vi::register()];
    }

    /**
     * Set locale value
     * 
     * @param string $locale
     * @return bool
     */
    public static function setLocale(string $locale)
    {
        return Cookies::set(LOCALE_KEY, $locale);
    }

    /**
     * Get locale value
     * 
     * @return string
     */
    public static function getLocale()
    {
        return Cookies::get(LOCALE_KEY) ?? LOCALE;
    }

    /**
     * Get locale value
     * 
     * @return array
     */
    public static function getCurrentLocaleData()
    {
        $locales = self::registerLocale();
        $locale = self::getLocale();
        if (isset($locales[$locale])) {
            return $locales[$locale];
        }
        self::setLocale(LOCALE);
        return $locales[LOCALE];
    }

    /**
     * Translate
     * 
     * @param string $key
     * @return string
     */
    public static function t(string $key)
    {
        $locales = self::getCurrentLocaleData();
        return isset($locales[$key]) ? $locales[$key] : $key;
    }
}
