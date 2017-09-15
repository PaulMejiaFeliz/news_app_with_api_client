<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->registerNamespaces(
    [
        'Newsapp\Helpers' => APP_PATH . '/helpers/'
    ]
)->register();
