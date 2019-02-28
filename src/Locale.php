<?php

namespace Simplon\Locale;

use Simplon\Locale\Readers\ReaderInterface;

/**
 * @package Simplon\Locale
 */
class Locale
{
    const FALLBACK_LOCALE = 'en';

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
    private $fallbackLocale;
    /**
     * @var string
     */
    private $currentLocale = self::FALLBACK_LOCALE;
    /**
     * @var null|string
     */
    private $group;
    /**
     * @var array
     */
    private $localeContent = [];

    /**
     * @param ReaderInterface $reader
     * @param array           $availableLocales
     * @param string          $fallbackLocale
     */
    public function __construct(ReaderInterface $reader, array $availableLocales = [], string $fallbackLocale = self::FALLBACK_LOCALE)
    {
        $this->reader = $reader;
        $this->availableLocales = $availableLocales;
        $this->fallbackLocale = $fallbackLocale;
    }

    /**
     * @return null|string
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param string $group
     *
     * @return Locale
     */
    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrentLocale(): string
    {
        return $this->currentLocale;
    }

    /**
     * @param string $locale
     *
     * @return Locale
     */
    public function setLocale(string $locale): self
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
     * @param array  $params
     *
     * @return string|null
     */
    public function get(string $key, array $params = []): ?string
    {
        // make sure that we have the locale content
        $this->loadLocaleContent($this->currentLocale);

        // handle content
        $contentKey = $this->getContentKey($this->currentLocale);

        if (empty($this->localeContent[$contentKey][$key]))
        {
            // make sure that we have the locale content
            $this->loadLocaleContent($this->fallbackLocale);

            // handle content
            $contentKey = $this->getContentKey($this->fallbackLocale);

            if (empty($this->localeContent[$contentKey][$key]))
            {
                return null;
            }
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
    private function isValidLocale(string $locale): bool
    {
        return in_array($locale, $this->availableLocales);
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    private function getContentKey(string $locale): string
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
     */
    private function loadLocaleContent(string $locale): Locale
    {
        $contentKey = $this->getContentKey($locale);

        if (empty($this->localeContent[$contentKey]))
        {
            $this->localeContent[$contentKey] = $this->reader->prepareLocale($locale, $this->getGroup());
        }

        return $this;
    }
}