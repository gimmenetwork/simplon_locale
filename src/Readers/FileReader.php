<?php

namespace Simplon\Locale\Readers;

use Simplon\Locale\LocaleException;

/**
 * Class FileReader
 * @package Simplon\Locale\Readers
 */
class FileReader implements ReaderInterface
{
    /**
     * @var
     */
    private $rootPath;

    /**
     * @param string $rootPath
     */
    public function __construct($rootPath)
    {
        $this->rootPath = $rootPath;
    }

    /**
     * @param string $locale
     * @param string $group
     *
     * @return array
     * @throws LocaleException
     */
    public function loadLocale($locale, $group = null)
    {
        if ($group !== null)
        {
            $locale = $locale . '/' . $group;
        }

        $fileName = $locale . '-locale.php';
        $pathFile = $this->rootPath . '/' . $fileName;

        if (file_exists($pathFile) === true)
        {
            /** @noinspection PhpIncludeInspection */
            return require $pathFile;
        }

        throw new LocaleException('Missing locale "' . $fileName . '" (assumed path: ' . $pathFile . ')');
    }
}