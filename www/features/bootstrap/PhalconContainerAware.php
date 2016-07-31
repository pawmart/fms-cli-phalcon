<?php

use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Cli\Console as ConsoleApp;

/**
 * Trait providing access to the di container of the Phalcon application.
 */
trait PhalconContainerAware
{
    /** @var CliDi */
    protected $di;


    /**
     * @return mixed
     */
    public static function getDi()
    {
        $dir = __DIR__ . '/../..';
        include $dir . '/config/loader.php';

        $config = include $dir . '/config/config.php';
        $di = new CliDi();
        include $dir . '/config/services.php';

        return $di;
    }

}