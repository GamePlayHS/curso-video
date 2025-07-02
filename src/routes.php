<?php
use core\Router;

$router = new Router();

/* HOME */

$router->get('/', 'HomeController@index');

/* CURSOS */

$router->get('/cursos', 'CursoController@index');
$router->get('/curso/incluir', 'CursoController@incluirCurso');
$router->post('/curso/incluir', 'CursoController@create');
$router->get('/curso/excluir/{codigo}', 'CursoController@incluirCurso');
