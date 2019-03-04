<?php

$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

Yaf_Registry::set("starttime", $starttime);

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/application');
define('LIB_PATH', ROOT_PATH . '/library');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('DATA_PATH', ROOT_PATH . '/data');

$application = new Yaf_Application(CONFIG_PATH . "/application.ini");
$application->bootstrap()->run();
