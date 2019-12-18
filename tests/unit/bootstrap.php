<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(-1);

/** @var Composer\Autoload\ClassLoader $autoLoader */
$autoLoader = require __DIR__ . '/../../vendor/autoload.php';


AnnotationRegistry::registerLoader('class_exists');

$_SERVER['DOCUMENT_ROOT'] = '/var/www/html/public';
$_SERVER['HTTP_HOST'] = 'dev.esprit.de';
$_SERVER['APP_ENV'] = 'dev';
