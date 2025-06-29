<?php
use core\Router;

$router = new Router();

/* HOME */

$router->get('/', 'HomeController@index');

/* CURSOS */

$router->get('/gerenciar-cursos', 'CursoController@index');
$router->get('/incluir-curso', 'CursoController@incluirCurso');
$router->post('/incluir-curso', 'CursoController@create');
