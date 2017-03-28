<?php

namespace Simplon\Locale\Readers;

/**
 * @package Simplon\Locale\Readers
 */
interface ReaderInterface
{
    /**
     * @param string $locale
     * @param null|string $group
     *
     * @return array
     * @throw LocaleException
     */
    public function prepareLocale(string $locale, ?string $group = null): array;
}