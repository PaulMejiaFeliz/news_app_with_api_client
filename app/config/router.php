<?php

use Phalcon\Mvc\Router;

$router = $di->getRouter();

//News Routes

$router->add('/', [
    'controller' => 'news',
    'action' => 'index'
]);

$router->add('/myNews', [
    'controller' => 'myNews',
    'action' => 'index'
]);

$router->add('/news/detail/:int', [
    'controller' => 'news',
    'action' => 'postDetails',
    'id' => 1
]);

$router->add('/news/add', [
    'controller' => 'myNews',
    'action' => 'addPost'
]);

$router->add('/news/edit/:int', [
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

$router->add('/register', [
    'controller' => 'account',
    'action' => 'register'
]);

$router->add('/login', [
    'controller' => 'account',
    'action' => 'login'
]);
$router->add('/logout', [
    'controller' => 'account',
    'action' => 'logout'
]);

$router->handle();