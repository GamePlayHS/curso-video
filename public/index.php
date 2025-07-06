<?php

use core\Controller;

session_start();
require '../vendor/autoload.php';
require '../src/routes.php';

$router->run( $router->routes );