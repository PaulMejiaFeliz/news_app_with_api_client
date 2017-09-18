<?php

$router = $di->getRouter();

// $router->add('/', [
//     'controller' => 'Index',
//     'action' => 'Index'
// ]);

// $router->add('/account/login', [
//     'controller' => 'Account',
//     'action' => 'login'
// ]);

$router->handle();
