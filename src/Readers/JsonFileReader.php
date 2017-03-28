<?php

namespace Simplon\Locale\Readers;

/**
 * Class JsonFileReader
 * @package Simplon\Locale\Readers
 */
class JsonFileReader extends FileReader
{
    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return 'json';
    }

    /**
     * @param string $pathFile
     *
     * @return array
     */
    public function loadLocale(string $pathFile): array
    {
        if (file_exists($pathFile))
        {
            return json_decode(file_get_contents($pathFile), true);
        }

        return [];
    }
}