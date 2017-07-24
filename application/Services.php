<?php

return [
    'config' => function ($c) {
        return Yaf_Registry::get('config');
    },

    'session' => function ($c) {
        return Yaf_Session::getInstance();
    },

    'log' => function ($c) {
        $log = new Monolog\Logger($c["config"]["log"]["name"]);
        $log_filename = $c["config"]["log"]["filedir"] . date("Ymd") . ".log";
        $log->pushHandler(new Monolog\Handler\StreamHandler($log_filename));
        $log->pushHandler(new Monolog\Handler\FirePHPHandler());
        return $log;
    },

    'cache' => function ($c) {
        $lefttime = $c["config"]["cache"]["lefttime"];
        $cache_dir = $c["config"]["cache"]["filedir"];
        $cache = new Symfony\Component\Cache\Simple\FilesystemCache("", $lefttime, $cache_dir);
        Yaf_Registry::set('cache', $cache);
        return $cache;
    },
];
