<?php

$loader = new \Phalcon\Loader();

/** dirs autoload */
$loader->registerDirs(
    [
        __DIR__ . '/../tasks',
    ]
);

/** register namespaces */
$loader->registerNamespaces(
    [
        "Pawel\\Fms" => __DIR__ . "/..//models/",
    ]
);

$loader->register();
