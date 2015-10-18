<?php

namespace Simplon\Locale;

use Simplon\Locale\Readers\ReaderInterface;

/**
 * Class Locale
 * @package Simplon\Locale
 */
class Locale
{
    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @var array
     */
    private $availableLocales;

    /**
     * @var string
     */
    private $currentLocale = 'en';

    /**
     * @var string
     */
    private $group;

    /**
     * @var array
     */
    private $localeContent = [];

    /**
     * @param ReaderInterface $reader
     * @param array $availableLocales
     */
    public function __construct(ReaderInterface $reader, $availableLocales = [])
    {
        $this->reader = $reader;
        $this->availableLocales = $availableLocales;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     *
     * @return Locale
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * @param string $locale
     *
     * @return Locale
     */
    public function setLocale($locale)
    {
        // validated locale
        if ($this->isValidLocale($locale))
        {
            $this->currentLocale = $locale;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param array $params
     *
     * @return string
     */
    public function get($key, $params = [])
    {
        // make sure that we have the locale content
        $this->loadLocaleContent($this->currentLocale);

        // handle content
        $contentKey = $this->getContentKey($this->currentLocale);

        if (empty($this->localeContent[$contentKey][$key]))
        {
            return $key;
        }

        $string = $this->localeContent[$contentKey][$key];

        // replace params
        if (empty($params) === false)
        {
            foreach ($params as $k => $v)
            {
                $string = str_replace('{' . $k . '}', $v, $string);
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
     * @param string $locale
     *
     * @return string
     */
    private function getContentKey($locale)
    {
        $contentKey = $locale;
        $group = $this->getGroup();

        if ($group !== null)
        {
            $contentKey = $locale . '-' . $group;
        }

        return $contentKey;
    }

    /**
     * @param string $locale
     *
     * @return Locale
     * @throws LocaleException
     */
    private function loadLocaleContent($locale)
    {
        $contentKey = $this->getContentKey($locale);

        if (empty($this->localeContent[$contentKey]))
        {
            $this->localeContent[$contentKey] = $this->reader->loadLocale($locale, $this->getGroup());
        }

        return $this;
    }
}