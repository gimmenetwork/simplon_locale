<?php

namespace Simplon\Locale\Readers;

use Simplon\Locale\LocaleException;

/**
 * Class FileReader
 * @package Simplon\Locale\Readers
 */
abstract class FileReader implements ReaderInterface
{
    /**
     * @var string[]
     */
    private $paths;

    /**
     * @param string[] $paths
     */
    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * @return string
     */
    abstract public function getFileExtension();

    /**
     * @param string $pathFile
     *
     * @return array
     */
    abstract public function loadLocale($pathFile);

    /**
     * @param string $locale
     * @param string $group
     *
     * @return array
     * @throws LocaleException
     */
    public function prepareLocale($locale, $group = null)
    {
        if ($group !== null)
        {
            $locale = $locale . '/' . $group;
        }

        $fileName = $locale . '-locale.' . $this->getFileExtension();
        $content = [];

        foreach ($this->paths as $path)
        {
            $pathFile = $path . '/' . $fileName;

            if (file_exists($pathFile) === false)
            {
                throw new LocaleException('Missing locale "' . $fileName . '" (assumed path: ' . $pathFile . ')');
            }

            /** @noinspection PhpIncludeInspection */
            $content = array_merge($content, $this->loadLocale($pathFile));
        }

        return $content;
    }
}