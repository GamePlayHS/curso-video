<?php
use core\Router;

$router = new Router();

// Home
$router->get('/', 'HomeController@index');
// Gerenciar Cursos
$router->get('/gerenciar-cursos', 'CursoController@index');
// Incluir
$router->get('/incluir-curso', 'HomeController@incluirCurso');
$router->post('/incluir-curso', 'HomeController@processaInclusaoCurso');
