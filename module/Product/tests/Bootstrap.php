<?php
use Zend\Mvc\Application;

class Bootstrap
{
    public static function go()
    {
        chdir(dirname(__DIR__ . '/../../../../'));
        include 'init_autoloader.php';
        Application::init(include 'config/application.config.php');
    }

}
Bootstrap::go();
