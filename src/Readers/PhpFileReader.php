<?php

namespace Simplon\Locale\Readers;

/**
 * Class PhpFileReader
 * @package Simplon\Locale\Readers
 */
class PhpFileReader extends FileReader
{
    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return 'php';
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
            /** @noinspection PhpIncludeInspection */
            return require $pathFile;
        }

        return [];
    }
}