<?php

use \Nette\Caching\Storages\FileStorage;
use \Nette\Loaders\RobotLoader;
use \Tester\Environment;

define('DIR_ROOT', __DIR__ . '/..');
define('DIR_TEMP', DIR_ROOT . '/temp');
define('DIR_TESTS', __DIR__);

require_once DIR_ROOT . '/vendor/autoload.php';

$loader = new RobotLoader;
$loader->addDirectory(DIR_ROOT . '/src');
$loader->setCacheStorage(new FileStorage(DIR_TEMP));
$loader->register();

Environment::setup();
