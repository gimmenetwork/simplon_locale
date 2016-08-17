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
    public function getFileExtension()
    {
        return 'json';
    }

    /**
     * @param string $pathFile
     *
     * @return array
     */
    public function loadLocale($pathFile)
    {
        return json_decode(file_get_contents($pathFile), true);
    }
}