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
    public function prepareLocale($locale, $group = null);
}