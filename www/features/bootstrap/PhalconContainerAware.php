<?php

use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Cli\Console as ConsoleApp;

trait PhalconContainerAware
{

    protected $di;


    /**
     * @return mixed
     */
    public static function getDi()
    {

        $dir = __DIR__ . '/../..';

        /**
         * Read auto-loader
         */
        include $dir . '/config/loader.php';

        /**
         * Read the configuration
         */
        $config = include $dir . '/config/config.php';

        /**
         * Read the services
         */
        $di = new CliDi();
        include $dir . '/config/services.php';

        return $di;

    }


}