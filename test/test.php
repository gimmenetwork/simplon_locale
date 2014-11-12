<?php

require __DIR__ . '/../vendor/autoload.php';
header('Content-Type: text/html; charset=utf-8');

$locale = new \Simplon\Locale\Locale(__DIR__ . '/locales', ['en', 'de']);
echo $locale->getCurrentLocale() . ' - ' . $locale->get('default', 'hello.there.name', ['name' => 'Tino']);
echo '<hr>';

$locale->setLocale('de');

echo $locale->getCurrentLocale() . ' - ' .$locale->get('default', 'hello.there.name', ['name' => 'Tino']);
echo '<hr>';
