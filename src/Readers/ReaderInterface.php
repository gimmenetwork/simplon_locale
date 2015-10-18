<?php

namespace Simplon\Locale\Readers;

/**
 * Interface ReaderInterface
 * @package Simplon\Locale\Readers
 */
interface ReaderInterface
{
    /**
     * @param string $locale
     * @param string $group
     *
     * @return array
     * @throw LocaleException
     */
    public function loadLocale($locale, $group = null);
}