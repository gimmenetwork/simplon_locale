<?php

namespace Simplon\Locale;

/**
 * Locale
 * @package Simplon\Locale
 * @author Tino Ehrich (tino@bigpun.me)
 */
class Locale
{
    /**
     * @var string
     */
    private $rootPathLocale;

    /**
     * @var array
     */
    private $availableLocales;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @var array
     */
    private $localeContent = [];

    /**
     * @param string $rootPathLocale
     * @param array $availableLocales
     * @param string $defaultLocale
     */
    public function __construct($rootPathLocale, $availableLocales = [], $defaultLocale = 'en')
    {
        // set root path
        $this->rootPathLocale = rtrim($rootPathLocale, '/');

        // list of valid locales
        $this->availableLocales = $availableLocales;

        // default/starting locale
        $this->defaultLocale = $defaultLocale;

        // load default
        $this->setLocale($defaultLocale);
    }

    /**
     * @return string
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * @param $locale
     *
     * @return bool
     */
    public function setLocale($locale)
    {
        // validated locale
        if ($this->isValidLocale($locale) === false)
        {
            return false;
        }

        // cache locale
        $this->currentLocale = $locale;

        return true;
    }

    /**
     * @param string $group
     * @param string $key
     * @param array $params
     *
     * @return string
     */
    public function get($group, $key, $params = [])
    {
        // make sure that we have the locale content
        $this->loadLocaleFile($this->currentLocale, $group);

        // build locale/group key
        $localeFileCacheKey = $this->currentLocale . '-' . $group;

        // return key if we don't have anything
        if (isset($this->localeContent[$localeFileCacheKey][$key]) === false)
        {
            return $key;
        }

        // get string
        $string = $this->localeContent[$localeFileCacheKey][$key];

        // replace params
        if (empty($params) === false)
        {
            foreach ($params as $k => $v)
            {
                $string = str_replace('{{' . $k . '}}', $v, $string);
            }
        }

        return (string)$string;
    }

    /**
     * @param string $locale
     *
     * @return bool
     */
    private function isValidLocale($locale)
    {
        return in_array($locale, $this->availableLocales);
    }

    /**
     * @param $locale
     * @param string $group
     *
     * @return bool
     * @throws LocaleException
     */
    private function loadLocaleFile($locale, $group = 'default')
    {
        $localeFileCacheKey = $locale . '/' . $group;

        // is locale already cached
        if (isset($this->localeContent[$localeFileCacheKey]))
        {
            return true;
        }

        // file path
        $pathLocale = $this->rootPathLocale . '/' . $locale . '/' . $group . '-locale.php';

        if (file_exists($pathLocale) === true)
        {
            $this->localeContent[$locale . '-' . $group] = require $pathLocale;

            return true;
        }

        throw new LocaleException('Missing locale "' . $locale . '/' . $group . '" (assumed path: ' . $pathLocale . ')');
    }
}