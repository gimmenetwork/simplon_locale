<?php

namespace Simplon\Locale\Readers;

/**
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
    abstract public function getFileExtension(): string;

    /**
     * @param string $pathFile
     *
     * @return array
     */
    abstract public function loadLocale(string $pathFile): array;

    /**
     * @param string $locale
     * @param string $group
     *
     * @return array
     */
    public function prepareLocale(string $locale, ?string $group = null): array
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

            /** @noinspection PhpIncludeInspection */
            $content = array_merge($content, $this->loadLocale($pathFile));
        }

        return $content;
    }
}