<?php
/**
 * Local variables
 *
 * @var \Phalcon\Config $config
 * @var \Phalcon\Di\FactoryDefault\Cli $di
 */

$di->setShared('config', function () use ($config) {
    return $config;
});

$di->setShared('db', function() use ($config) {

    $config = [
        'dbname' => $config->database->dbname,
    ];
    return new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
});
