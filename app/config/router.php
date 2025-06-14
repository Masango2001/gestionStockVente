<?php

$router = $di->getRouter();
$router->add('/login', [
    'controller' => 'auth',
    'action' => 'login'
]);
// Define your routes here


$router->handle($_SERVER['REQUEST_URI']);
