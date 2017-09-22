<?php

use Phalcon\Mvc\Router;

$router = $di->getRouter();

//News Routes

$router->addGet('/', [
    'controller' => 'news',
    'action' => 'index'
]);

$router->addGet('/myNews', [
    'controller' => 'myNews',
    'action' => 'index'
]);

$router->addGet('/news/detail/:int', [
    'controller' => 'news',
    'action' => 'postDetails',
    'id' => 1
]);

$router->addGet('/news/add', [
    'controller' => 'myNews',
    'action' => 'addPostGet'
]);

$router->addPost('/news/add', [
    'controller' => 'myNews',
    'action' => 'addPost'
]);

$router->addGet('/news/edit/:int', [
    'controller' => 'myNews',
    'action' => 'editPostGet',
    'id' => 1
]);

$router->addPost('/news/edit/:int', [
    'controller' => 'myNews',
    'action' => 'editPost',
    'id' => 1
]);

$router->add('/news/delete', [
    'controller' => 'myNews',
    'action' => 'deletePost'
]);

//Comments Routes

$router->addPost('/comments/add/:int', [
    'controller' => 'comments',
    'action' => 'addComment',
    'newsId' => 1
]);

$router->addPost('/comments/edit', [
    'controller' => 'comments',
    'action' => 'editComment'
]);

$router->addPost('/comments/delete', [
    'controller' => 'comments',
    'action' => 'deleteComment'
]);

//Account Routes

$router->addGet('/register', [
    'controller' => 'account',
    'action' => 'registerGet'
]);

$router->addPost('/register', [
    'controller' => 'account',
    'action' => 'register'
]);

$router->addGet('/login', [
    'controller' => 'account',
    'action' => 'loginGet'
]);

$router->addPost('/login', [
    'controller' => 'account',
    'action' => 'login'
]);

$router->addGet('/logout', [
    'controller' => 'account',
    'action' => 'logout'
]);

//Error route

$router->addGet('/error/:params', [
    'controller' => 'index',
    'action' => 'error',
    'message' => 1
]);

$router->handle();
