<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use src\models\Curso;

class CursoController extends Controller {

    public function index() {
        // Exibe a lista de cursos
        $oConexao = Database::getInstance();
        $stmt     = $oConexao->query("SELECT * FROM tbcurso");
        $cursos   = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->render('gerenciar-cursos', ['cursos' => $cursos]);
    }

    public function incluirCurso() {
        $this->render('incluir-curso');
    }

    public function show($id) {
        // Mostra detalhes de um curso específico
    }

    public function create() {
        $oConexao = Database::getInstance();

        if (isset($_FILES["cursoImagem"]) && $_FILES["cursoImagem"]["error"] == 0) {
            $sNomeArquivo    = basename($_FILES["cursoImagem"]["name"]);
            $sNomeCurso      = filter_input(INPUT_POST, 'cursoNome');
            $sDescricaoCurso = filter_input(INPUT_POST, 'cursoDescricao');

            // Lê o conteúdo da imagem em binário
            $imageData = file_get_contents($_FILES["cursoImagem"]["tmp_name"]);

            // Exemplo de inserção no banco (ajuste conforme sua tabela)
            $stmt = $oConexao->prepare("INSERT INTO tbcurso (curnome, curdescricao, curimagem, curnomeimagem, curtipoimagem) VALUES (:nome, :descricao, :imagem, :nomeImagem, :tipoImagem)");
            $stmt->bindParam(':nome'      , $sNomeCurso);
            $stmt->bindParam(':descricao' , $sDescricaoCurso);
            $stmt->bindParam(':imagem'    , $imageData, \PDO::PARAM_LOB);
            $stmt->bindParam(':nomeImagem', $sNomeArquivo);
            $stmt->bindParam(':tipoImagem', $_FILES["cursoImagem"]["type"]);

            if ($stmt->execute()) {
                $this->redirect('/gerenciar-cursos');
                exit("Curso Inserido com Sucesso!");
            } else {
                echo "Erro ao Salvar o Curso.";
            }
        } else {
            echo "Nenhum arquivo enviado ou ocorreu um erro.";
        }
    }

    public function edit(int $id) {
        // Exibe formulário para editar um curso existente
    }

    public function update(int $id, object $data) {
        // Atualiza um curso existente
    }

    public function destroy(int $id) {
        // Remove um curso
    }

}