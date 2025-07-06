<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use PDO;

class ControllerVideo extends Controller {

    public function index($args) {
        $oConexao = Database::getInstance();

        // Parâmetros de filtro e paginação
        $curcodigo = isset($args['curcodigo']) ? (int)$args['curcodigo'] : null;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $porPagina = 10;
        $offset = ($paginaAtual - 1) * $porPagina;

        // Monta a query base
        $sql = "SELECT * FROM tbvideo WHERE 1=1";
        $params = [];

        // Filtro por curso
        if ($curcodigo) {
            $sql .= " AND curcodigo = :curcodigo";
            $params[':curcodigo'] = $curcodigo;
        }

        // Conta total para paginação
        $sqlCount = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
        $stmtCount = $oConexao->prepare($sqlCount);
        $stmtCount->execute($params);
        $totalRegistros = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPaginas = ceil($totalRegistros / $porPagina);

        // Adiciona ordenação e paginação
        $sql .= " ORDER BY vidcodigo DESC LIMIT :limit OFFSET :offset";
        $stmt = $oConexao->prepare($sql);

        // Bind dos parâmetros
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        }
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renderiza a view de consulta de vídeos, passando os vídeos encontrados e paginação
        $this->render('ViewConsultaVideo', [
            'videos' => $videos,
            'paginaAtual' => $paginaAtual,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function show($args) {
        // Lógica para exibir um vídeo específico
    }

    public function create() {
        // Lógica para exibir formulário de criação de vídeo
    }

    public function store($args) {
        // Lógica para salvar um novo vídeo
    }

    public function edit($args) {
        // Lógica para exibir formulário de edição de vídeo
    }

    public function update($args) {
        // Lógica para atualizar um vídeo existente
    }

    public function delete($args) {
        // Lógica para deletar um vídeo
        $oConexao = Database::getInstance();
        $id = isset($args['codigo']) ? (int)$args['codigo'] : null;

        if ($id) {
            $stmt = $oConexao->prepare("DELETE FROM tbvideo WHERE vidcodigo = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                echo "<script>alert('Vídeo excluído com sucesso.');</script>";
            } else {
                echo "<script>alert('Erro ao excluir o vídeo.');</script>";
            }
        } else {
            echo "<script>alert('ID do vídeo inválido.');</script>";
        }
        $this->redirect('/cursos');
    }

}