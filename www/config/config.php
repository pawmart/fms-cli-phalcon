<?php

return new \Phalcon\Config([

    'version'      => '1.0',
    'printNewLine' => true,
    "database"     => [
        "adapter" => "sqlite",
        "dbname"  => __DIR__ . "/test.sqlite",
    ],
    "application"  => [
        "modelsDir" => __DIR__ . "/../models",
    ],
]);
