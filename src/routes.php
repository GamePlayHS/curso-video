<?php
use core\Router;

$router = new Router();

/* HOME */

$router->get('/', 'HomeController@index');

/* CURSOS */

$router->get('/cursos', 'ControllerCurso@index');
$router->get('/curso/incluir', 'ControllerCurso@incluirCurso');
$router->post('/curso/incluir', 'ControllerCurso@create');
$router->get('/curso/alterar/{codigo}', 'ControllerCurso@edit');
$router->post('/curso/alterar', 'ControllerCurso@update');
$router->get('/curso/excluir/{codigo}', 'ControllerCurso@delete');
$router->get('/curso/visualizar/{codigo}', 'ControllerCurso@show');
