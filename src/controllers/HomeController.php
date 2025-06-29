<?php
namespace src\controllers;

use \core\Controller;

class HomeController extends Controller {

    public function index() {
        $this->render('home', ['nome' => 'Bonieky']);
    }

    public function incluirCurso() {
        $this->render('incluir-curso');
    }

    /**
     * Processa a Inclusão do Curso
     * @return void
     */
    public function processaInclusaoCurso() {
        if (isset($_FILES["cursoImagem"]) && $_FILES["cursoImagem"]["error"] == 0) {
            $nomeArquivo = basename($_FILES["cursoImagem"]["name"]);

            // Verifica se o upload foi bem-sucedido
            if (true) {
                echo "Upload realizado com sucesso!";
            } else {
                echo "Erro ao enviar o arquivo.";
            }
        } else {
            echo "Nenhum arquivo enviado ou ocorreu um erro.";
        }
    }

}