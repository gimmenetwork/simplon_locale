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
     * @var string[]
     */
    private $paths;

    /**
     * @var string
     */
    private $fileExtension;

    /**
     * @param string[] $paths
     * @param string $fileExtension
     */
    public function __construct(array $paths, $fileExtension = 'php')
    {
        $this->paths = $paths;
        $this->fileExtension = $fileExtension;
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

        $fileName = $locale . '-locale.' . $this->fileExtension;
        $content = [];

        foreach ($this->paths as $path)
        {
            $pathFile = $path . '/' . $fileName;

            if (file_exists($pathFile) === false)
            {
                throw new LocaleException('Missing locale "' . $fileName . '" (assumed path: ' . $pathFile . ')');
            }

            /** @noinspection PhpIncludeInspection */
            $content = array_merge($content, require $pathFile);
        }

        return $content;
    }
}