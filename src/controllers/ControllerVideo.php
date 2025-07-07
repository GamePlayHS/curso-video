<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use core\Principal;
use getID3;
use PDO;

require_once dirname(__DIR__, 2) . '/core/getid3/getid3.php';

class ControllerVideo extends Controller {

    public function index($args) {
        $oConexao = Database::getInstance();

        // Parâmetros de filtro e paginação
        $curcodigo = isset($args['curso']) ? (int)$args['curso'] : null;
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
            'codigoCurso' => $curcodigo,
            'paginaAtual' => $paginaAtual,
            'totalPaginas' => $totalPaginas
        ]);
    }

    public function incluirVideo($args) {
        $this->render('ViewManutencaoVideo', [
            'codigoCurso' => $args['curso'] ?? null,
            'action' => Principal::getBaseUrl() . '/curso/' . ($args['curso'] ?? null) . '/video/incluir',
        ]);
    }

    public function create($args) {
        $oConexao = Database::getInstance();
        $titulo = htmlspecialchars(filter_input(INPUT_POST, 'titulo'));
        $descricao = htmlspecialchars(filter_input(INPUT_POST, 'descricao'));
        $cursoCodigo = $args['curso'];

        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
            // Diretório onde os vídeos serão salvos
            $diretorio = Principal::getPathUpload() . '/curso_' . $cursoCodigo;
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

            $nomeArquivo = uniqid() . '_' . basename($_FILES['arquivo']['name']);
            $caminhoRelativo = 'curso_' . $cursoCodigo . '/' . $nomeArquivo;
            $caminhoCompleto = $diretorio . '/' . $nomeArquivo;

            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
                $getID3 = new getID3();
                $fileInfo = $getID3->analyze($caminhoCompleto);
                $duracaoSegundos = isset($fileInfo['playtime_seconds']) ? $fileInfo['playtime_seconds'] : null;
    
                $stmt = $oConexao->prepare("INSERT INTO tbvideo (vidtitulo, viddescricao, vidcaminho, vidduracao, curcodigo) VALUES (:titulo, :descricao, :caminho, :duracao, :curso)");
                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':descricao', $descricao);
                $stmt->bindValue(':caminho', $caminhoRelativo);
                $stmt->bindValue(':duracao', $duracaoSegundos);
                $stmt->bindValue(':curso', (int)$cursoCodigo);
            } else {
                echo "<script>alert('Erro ao salvar o arquivo de vídeo.');</script>";
                $this->redirect('/curso/' . (int)$cursoCodigo . '/videos');
                return;
            }
        } else {
            echo "<script>alert('Tipo de vídeo não suportado ou arquivo não enviado.');</script>";
            $this->redirect('/curso/' . (int)$cursoCodigo . '/videos');
            return;
        }

        if ($stmt->execute()) {
            echo "<script>alert('Vídeo cadastrado com sucesso.');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar o vídeo.');</script>";
        }
        
        // Redireciona para a lista de vídeos do curso
        $this->redirect('/curso/' . (int)$cursoCodigo . '/videos');
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