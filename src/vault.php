#!/usr/bin/env php
<?php

$i=0;
do {
    $autoloader = __DIR__ . str_repeat ('/..', $i) .  '/vendor/autoload.php';
    $i++;
} while ($i<6 && !is_file($autoloader));
require_once $autoloader;

use Symfony\Component\Console\Application;

$app = new Application('Vault', '@package_version@');

$app->add(new \Vault\Command\EncryptCommand);
$app->add(new \Vault\Command\DecryptCommand);

$app->run();