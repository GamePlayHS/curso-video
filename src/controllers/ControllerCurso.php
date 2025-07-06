<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use PDO;

class ControllerCurso extends Controller {

    public function index() {
        $iPaginaAtual = filter_input(INPUT_GET, 'pagina') ?? 1;
        $iTotalPorPagina = 20; // Defina o total de cursos por página

        $oConexao = Database::getInstance();

        // Conta o total de cursos para calcular o total de páginas
        $stmtTotal = $oConexao->query("SELECT COUNT(*) as total FROM tbcurso");
        $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPaginas = ceil($totalRegistros / $iTotalPorPagina);

        // Calcula o offset para a consulta paginada
        $offset = ($iPaginaAtual - 1) * $iTotalPorPagina;

        // Busca apenas os cursos da página atual
        $sSql = "SELECT * FROM tbcurso ORDER BY curcodigo DESC LIMIT :limit OFFSET :offset";
        $stmt = $oConexao->prepare($sSql);
        $stmt->bindValue(':limit', $iTotalPorPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('ViewConsultaCurso', [
            'cursos' => $cursos,
            'paginaAtual' => $iPaginaAtual,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function incluirCurso() {
        $this->render('ViewManutencaoCurso');
    }

    /**
     * Abre a Tela de Visualização do Curso
     * @param mixed $args
     * @return void
     */
    public function show($args) {
        $curso = $this->carregaDadosCurso($args['codigo']);
        if ($curso) {
            $this->render('ViewManutencaoCurso', ['curso' => $curso]);
        } else {
            echo "<script>alert('Curso não encontrado.'); window.location.href = '/cursos';</script>";
        }
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
            $stmt->bindParam(':imagem'    , $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':nomeImagem', $sNomeArquivo);
            $stmt->bindParam(':tipoImagem', $_FILES["cursoImagem"]["type"]);

            if ($stmt->execute()) {
                $this->redirect('/cursos');
                exit("Curso Inserido com Sucesso!");
            } else {
                echo "<script>alert('Erro ao Salvar o Curso.'); window.location.href = '/cursos';</script>";
            }
        } else {
            echo "<script>alert('Nenhum arquivo enviado ou ocorreu um erro.'); window.location.href = '/cursos';</script>";
        }
    }

    public function edit($args) {
        $curso = $this->carregaDadosCurso($args['codigo']);

        if ($curso) {
            $this->render('ViewManutencaoCurso', ['curso' => $curso]);
        } else {
            echo "<script>alert('Curso não encontrado.'); window.location.href = '/cursos';</script>";
        }
    }

    public function update($args) {
        // Atualiza um curso existente
    }

    public function delete($args) {
        $oConexao = Database::getInstance();

        // Exclui o curso do banco de dados
        $stmt = $oConexao->prepare("DELETE FROM tbcurso WHERE curcodigo = :codigo");
        $stmt->bindParam(':codigo', $args['codigo'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert(Curso Excluído com Sucesso!'); /*window.location.href = '/cursos'*/;</script>";
            $this->redirect('/cursos');
        } else {
            echo "<script>alert('Erro ao Excluir o Curso.'); /*window.location.href = '/cursos'*/;</script>";
            exit;
        }
    }

    /* ==================================================================================================================================================================================================================== */
    /* ================================================================================================== MÉTODOS GERAIS ================================================================================================== */
    /* ==================================================================================================================================================================================================================== */

    /**
     * Retorna os Dados do Curso
     * @param int $iCodigo Identificador do Curso
     * @return array
     */
    public function carregaDadosCurso($iCodigo) {
        $oConexao = Database::getInstance();

        // Busca o curso pelo ID
        $stmt = $oConexao->prepare("SELECT * FROM tbcurso WHERE curcodigo = :codigo");
        $stmt->bindParam(':codigo', $iCodigo, PDO::PARAM_INT);
        $stmt->execute();
        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($curso) {
            return $curso;
        }
        return [];
    }

}