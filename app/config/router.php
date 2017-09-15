<?php

$router = $di->getRouter();

// Define your routes here
$router->addGet('/', [
    'Newsapp\Controllers\IndexController',
    'Index'
]);

$router->handle();
