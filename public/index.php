<?php

session_start();
require '../vendor/autoload.php';
require '../src/routes.php';
require '../core/funcoes.php';

$router->run( $router->routes );