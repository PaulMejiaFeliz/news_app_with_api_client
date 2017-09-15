<?php
use Phalcon\Di\FactoryDefault;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('WEB_URL', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

//try {
    //composer autoload
    require_once __DIR__ . '/../vendor/autoload.php';
    
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();
    
    /**
     * Get config service for use in inline setup below
     */
    $config = include APP_PATH . "/config/config.php";;

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';
    
    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';
    
    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());

// } catch (\Exception $e) {
//     echo $e->getMessage() . '<br>';
//     echo '<pre>' . $e->getTraceAsString() . '</pre>';
// }
