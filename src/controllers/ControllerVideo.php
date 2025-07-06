<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use core\Principal;
use PDO;

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
            'action' => Principal::getBaseUrl() . '/curso/' . ($args['curso'] ?? null) . '/videos/incluir',
        ]);
    }

    public function create() {
        $oConexao = Database::getInstance();
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
        $tipoVideo = filter_input(INPUT_POST, 'tipo_video', FILTER_SANITIZE_STRING);
        $cursoCodigo = filter_input(INPUT_POST, 'curso_codigo', FILTER_VALIDATE_INT);

        if ($tipoVideo === 'arquivo' && isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
            // Diretório onde os vídeos serão salvos
            $diretorio = __DIR__ . '/../../../public/videos/';
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

            $nomeArquivo = uniqid('video_') . '_' . basename($_FILES['arquivo']['name']);
            $caminhoRelativo = 'videos/' . $nomeArquivo;
            $caminhoCompleto = $diretorio . $nomeArquivo;

            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminhoCompleto)) {
                $stmt = $oConexao->prepare("INSERT INTO tbvideo (vidtitulo, viddescricao, vidtipo, vidcaminho, curcodigo) VALUES (:titulo, :descricao, :tipo, :caminho, :curso)");
                $stmt->bindValue(':caminho', $caminhoRelativo);
            } else {
                echo "<script>alert('Erro ao salvar o arquivo de vídeo.');</script>";
                $this->redirect('/curso/' . (int)$cursoCodigo . '/videos');
                return;
            }
        } else {
            $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
            $stmt = $oConexao->prepare("INSERT INTO tbvideo (vidtitulo, viddescricao, vidtipo, vidurl, curcodigo) VALUES (:titulo, :descricao, :tipo, :url, :curso)");
            $stmt->bindValue(':url', $url);
        }

        // Bind dos outros parâmetros
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':tipo', $tipoVideo);
        $stmt->bindValue(':curso', (int)$cursoCodigo);

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