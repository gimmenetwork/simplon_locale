<?php

use Simplon\Locale\Locale;
use Simplon\Locale\Readers\PhpFileReader;

require __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$reader = new PhpFileReader([__DIR__ . '/locales']);
$locale = new Locale($reader, ['en', 'de']);

// ----------------------------------------------

echo $locale->getCurrentLocale() . ' - ' . $locale->get('hello.there.name', ['name' => 'Tino']);
echo "\n\n";

// ----------------------------------------------

$locale->setLocale('de');

echo $locale->getCurrentLocale() . ' - ' . $locale->get('hello.there.name', ['name' => 'Tino']);
echo "\n\n";

// ----------------------------------------------

$locale->setLocale('en')->setGroup('foo');

echo $locale->getCurrentLocale() . ' - ' . $locale->get('hello.there.name', ['name' => 'Tino']);
echo "\n\n";