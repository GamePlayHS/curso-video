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

    public function show($args) {
        $oConexao = Database::getInstance();
        $iCodigoCurso = $args['curso'] ?? null;
        $iCodigoVideo = $args['codigo'] ?? null;

        if ($iCodigoCurso && $iCodigoVideo) {
            $stmt = $oConexao->prepare("SELECT * FROM tbvideo WHERE vidcodigo = :codigoVideo AND curcodigo = :codigoCurso");
            $stmt->bindValue(':codigoCurso', $iCodigoCurso, PDO::PARAM_INT);
            $stmt->bindValue(':codigoVideo', $iCodigoVideo, PDO::PARAM_INT);
            $stmt->execute();
            $video = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($video) {
                // Renderiza a view de visualização do vídeo
                $this->render('ViewManutencaoVideo', [
                    'video' => $video,
                    'caminhoCompleto' => Principal::getPathUpload() . '/' . $video['vidcaminho'],
                    'codigoCurso' => $iCodigoCurso,
                    'visualizacao' => true,
                ]);
                return;
            } else {
                echo "<script>alert('Vídeo não encontrado.');</script>";
            }
        } else {
            echo "<script>alert('ID do vídeo inválido.');</script>";
        }
        $this->redirect('/cursos');
    }

    public function edit($args) {
        $oConexao = Database::getInstance();
        $id = isset($args['codigo']) ? (int)$args['codigo'] : null;

        if ($id) {
            $stmt = $oConexao->prepare("SELECT * FROM tbvideo WHERE vidcodigo = :codigo");
            $stmt->bindValue(':codigo', $id, PDO::PARAM_INT);
            $stmt->execute();
            $video = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($video) {
                $this->render('ViewManutencaoVideo', [
                    'video' => $video,
                    'codigoCurso' => $video['curcodigo'],
                    'action' => Principal::getBaseUrl() . '/curso/' . $video['curcodigo'] . '/video/alterar/' . $video['vidcodigo'],
                    'alteracao' => true
                ]);
                return;
            } else {
                echo "<script>alert('Vídeo não encontrado.');</script>";
            }
        } else {
            echo "<script>alert('ID do vídeo inválido.');</script>";
        }
        $this->redirect('/cursos');
    }

    public function update($args) {
        $oConexao = Database::getInstance();
        $id = isset($args['codigo']) ? (int)$args['codigo'] : null;
        $cursoCodigo = isset($args['curso']) ? (int)$args['curso'] : null;

        if (!$id || !$cursoCodigo) {
            echo "<script>alert('Dados inválidos para alteração.');</script>";
            $this->redirect('/curso/' . $cursoCodigo . '/videos');
            return;
        }

        // Carrega os dados atuais do vídeo
        $stmt = $oConexao->prepare("SELECT * FROM tbvideo WHERE vidcodigo = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $video = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$video) {
            echo "<script>alert('Vídeo não encontrado.');</script>";
            $this->redirect('/curso/' . $cursoCodigo . '/videos');
            return;
        }

        // Carrega os dados do formulário
        $titulo = htmlspecialchars(filter_input(INPUT_POST, 'titulo'));
        $descricao = htmlspecialchars(filter_input(INPUT_POST, 'descricao'));

        $novoCaminhoRelativo = $video['vidcaminho'];
        $novaDuracao = $video['vidduracao'];

        // Se um novo arquivo foi anexado, substitui o antigo
        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
            $diretorio = Principal::getPathUpload() . '/curso_' . $cursoCodigo;
            if (!is_dir($diretorio)) {
                mkdir($diretorio, 0777, true);
            }

            // Remove o arquivo antigo, se existir
            $caminhoAntigo = $diretorio . '/' . basename($video['vidcaminho']);
            if (is_file($caminhoAntigo)) {
                unlink($caminhoAntigo);
            }

            $nomeArquivo = uniqid() . '_' . basename($_FILES['arquivo']['name']);
            $novoCaminhoRelativo = 'curso_' . $cursoCodigo . '/' . $nomeArquivo;
            $novoCaminhoCompleto = $diretorio . '/' . $nomeArquivo;

            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $novoCaminhoCompleto)) {
                $getID3 = new \getID3();
                $fileInfo = $getID3->analyze($novoCaminhoCompleto);
                $novaDuracao = isset($fileInfo['playtime_seconds']) ? $fileInfo['playtime_seconds'] : null;
            } else {
                echo "<script>alert('Erro ao salvar o novo arquivo de vídeo.');</script>";
                $this->redirect('/curso/' . $cursoCodigo . '/videos');
                return;
            }
        }

        // Atualiza os dados no banco
        $stmt = $oConexao->prepare("UPDATE tbvideo SET vidtitulo = :titulo, viddescricao = :descricao, vidcaminho = :caminho, vidduracao = :duracao WHERE vidcodigo = :id");
        $stmt->bindValue(':titulo', $titulo);
        $stmt->bindValue(':descricao', $descricao);
        $stmt->bindValue(':caminho', $novoCaminhoRelativo);
        $stmt->bindValue(':duracao', $novaDuracao);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Vídeo alterado com sucesso.');</script>";
        } else {
            echo "<script>alert('Erro ao alterar o vídeo.');</script>";
        }

        $this->redirect('/curso/' . $cursoCodigo . '/videos');
    }

    public function delete($args) {
        $oConexao = Database::getInstance();
        $iCodigoCurso = $args['curso'] ?? null;
        $iCodigoVideo = $args['codigo'] ?? null;

        if ($iCodigoCurso && $iCodigoVideo) {
            // Busca o caminho do arquivo antes de excluir do banco
            $stmt = $oConexao->prepare("SELECT vidcaminho, curcodigo FROM tbvideo WHERE curcodigo = :codigoCurso and vidcodigo = :codigoVideo");
            $stmt->bindValue(':codigoCurso', $iCodigoCurso, PDO::PARAM_INT);
            $stmt->bindValue(':codigoVideo', $iCodigoVideo, PDO::PARAM_INT);
            $stmt->execute();
            $video = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($video) {
                // Monta o caminho físico do arquivo
                $diretorio = Principal::getPathUpload() . '/curso_' . $video['curcodigo'];
                $caminhoFisico = $diretorio . '/' . basename($video['vidcaminho']);

                // Exclui o arquivo se existir
                if (is_file($caminhoFisico)) {
                    unlink($caminhoFisico);
                }

                // Exclui do banco
                $stmt = $oConexao->prepare("DELETE FROM tbvideo WHERE curcodigo = :codigoCurso and vidcodigo = :codigoVideo");
                $stmt->bindValue(':codigoCurso', $iCodigoCurso, PDO::PARAM_INT);
                $stmt->bindValue(':codigoVideo', $iCodigoVideo, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    echo "<script>alert('Vídeo excluído com sucesso.');</script>";
                } else {
                    echo "<script>alert('Erro ao excluir o vídeo.');</script>";
                }
            } else {
                echo "<script>alert('Vídeo não encontrado.');</script>";
            }
        } else {
            echo "<script>alert('Código do vídeo inválido.');</script>";
        }
        $this->redirect('/cursos');
    }

}