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

/* VÍDEOS */

$router->get('/curso/{codigoCurso}/videos', 'ControllerVideo@index');
$router->get('/curso/{codigoCurso}/video/incluir', 'ControllerVideo@incluirVideo');
$router->post('/curso/{codigoCurso}/video/incluir', 'ControllerVideo@create');
$router->get('/curso/{codigoCurso}/video/alterar/{id}', 'ControllerVideo@edit');
$router->post('/video/alterar', 'ControllerVideo@update');
$router->get('/video/excluir/{id}', 'ControllerVideo@delete');
$router->get('/video/visualizar/{id}', 'ControllerVideo@show');  
