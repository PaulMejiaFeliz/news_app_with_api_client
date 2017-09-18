<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as Flash;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.volt' => function ($view) {
            $config = $this->getConfig();

            $volt = new VoltEngine($view, $this);

            $volt->setOptions([
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ]);

            // $compiler = $volt->getCompiler();
            // $compiler->addFunction('nl2br', 'nl2br');

            return $volt;
        },
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new Flash([
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () use ($config) {
    $memcache = new \Phalcon\Session\Adapter\Memcache(array(
        'host' => $config->memcache->host, // mandatory
        'post' => $config->memcache->port, // optional (standard: 11211)
        'lifetime' => 8600, // optional (standard: 8600)
        'prefix' => 'naruhodo', // optional (standard: [empty_string]), means memcache key is my-app_31231jkfsdfdsfds3
        'persistent' => false, // optional (standard: false)
    ));

    //only start the session if its not already started
    if (!isset($_SESSION)) {
        $memcache->start();
    }

    return $memcache;
});

$di->set(
    'customTags',
    new Newsapp\Helpers\CustomTags($di->get('request'))
);
