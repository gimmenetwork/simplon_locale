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
    public function getFileExtension()
    {
        return 'php';
    }

    /**
     * @param string $pathFile
     *
     * @return array
     */
    public function loadLocale($pathFile)
    {
        /** @noinspection PhpIncludeInspection */
        return require $pathFile;
    }
}