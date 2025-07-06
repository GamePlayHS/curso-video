<?php

namespace core;

class Controller {

    public function __construct() {
        // Lista de rotas públicas (ajuste conforme necessário)
        $rotasPublicas = ['/curso-video/public/login', '/curso-video/public/loginInvalido', '/curso-video/public/register'];
        $rotaAtual     = $_SERVER['REQUEST_URI'];

        // Se não estiver logado e não for rota pública, redireciona
        if (empty($_SESSION['usuario']) && !in_array($rotaAtual, $rotasPublicas)) {
            $this->redirect('/login');
        }
    }

    protected function redirect($url) {
        header("Location: " . Principal::getBaseUrl() . $url);
        exit;
    }

    private function _render($folder, $viewName, $viewData = []) {
        if(file_exists('../src/views/'.$folder.'/'.$viewName.'.php')) {
            extract($viewData);
            $render = fn($vN, $vD = []) => $this->renderPartial($vN, $vD);
            $base   = Principal::getBaseUrl();
            require '../src/views/'.$folder.'/'.$viewName.'.php';
        }
    }

    private function renderPartial($viewName, $viewData = []) {
        $this->_render('partials', $viewName, $viewData);
    }

    public function render($viewName, $viewData = []) {
        $this->_render('pages', $viewName, $viewData);
    }

}