<?php
use core\Router;

$router = new Router();

/* LOGIN */

$router->get('/login', 'ControllerLogin@index');
$router->get('/loginInvalido', 'ControllerLogin@index');
$router->post('/login', 'ControllerLogin@login');
$router->get('/logout', 'ControllerLogin@logout');

/* USUÁRIO */

$router->get('/usuario/cadastrar', 'ControllerUsuario@index');
$router->post('/usuario/cadastrar', 'ControllerUsuario@register');
$router->get('/usuario/dadosCadastrais', 'ControllerUsuario@dadosCadastrais');

/* HOME */

$router->get('/', 'ControllerHome@index');

/* CURSOS */

$router->get('/cursos', 'ControllerCurso@index');
$router->get('/curso/incluir', 'ControllerCurso@incluirCurso');
$router->post('/curso/incluir', 'ControllerCurso@create');
$router->get('/curso/alterar/{codigo}', 'ControllerCurso@edit');
$router->post('/curso/alterar', 'ControllerCurso@update');
$router->get('/curso/excluir/{codigo}', 'ControllerCurso@delete');
$router->get('/curso/visualizar/{codigo}', 'ControllerCurso@show');

/* VÍDEOS */

$router->get('/curso/{curso}/videos', 'ControllerVideo@index');
$router->get('/curso/{curso}/video/incluir', 'ControllerVideo@incluirVideo');
$router->post('/curso/{curso}/video/incluir', 'ControllerVideo@create');
$router->get('/curso/{curso}/video/alterar/{codigo}', 'ControllerVideo@edit');
$router->post('/video/alterar', 'ControllerVideo@update');
$router->get('/video/excluir/{codigo}', 'ControllerVideo@delete');
$router->get('/video/visualizar/{codigo}', 'ControllerVideo@show');  
