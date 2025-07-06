<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use core\Principal;
use PDO;
use src\models\Curso;

class ControllerCurso extends Controller {

    public function index() {
        $iPaginaAtual = filter_input(INPUT_GET, 'pagina') ?? 1;
        $iTotalPorPagina = 20; // Defina o total de cursos por página

        $oConexao = Database::getInstance();

        // Conta o total de cursos para calcular o total de páginas
        $stmtTotal = $oConexao->query("SELECT COUNT(*) as total FROM tbcurso ");
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
        $this->render('ViewManutencaoCurso', ['action' => Principal::getBaseUrl() . '/curso/incluir']);
    }

    /**
     * Abre a Tela de Visualização do Curso
     * @param mixed $args
     * @return void
     */
    public function show($args) {
        $curso = $this->carregaDadosCurso($args['codigo'] ?? null);
        if ($curso) {
            $this->render('ViewManutencaoCurso', ['curso' => $curso, 'visualizacao' => true]);
        } else {
            echo "<script>alert('Curso não encontrado.');</script>";
            $this->redirect('/cursos');
        }
    }

    public function create() {
        $oConexao = Database::getInstance();

        if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
            $sNomeArquivo    = basename($_FILES["imagem"]["name"]);
            $sNomeCurso      = filter_input(INPUT_POST, 'nome');
            $sDescricaoCurso = filter_input(INPUT_POST, 'descricao');

            // Lê o conteúdo da imagem em binário
            $imageData = file_get_contents($_FILES["imagem"]["tmp_name"]);

            // Exemplo de inserção no banco (ajuste conforme sua tabela)
            $stmt = $oConexao->prepare("INSERT INTO tbcurso (curnome, curdescricao, curimagem, curnomeimagem, curtipoimagem) VALUES (:nome, :descricao, :imagem, :nomeImagem, :tipoImagem)");
            $stmt->bindParam(':nome'      , $sNomeCurso);
            $stmt->bindParam(':descricao' , $sDescricaoCurso);
            $stmt->bindParam(':imagem'    , $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':nomeImagem', $sNomeArquivo);
            $stmt->bindParam(':tipoImagem', $_FILES["imagem"]["type"]);

            if ($stmt->execute()) {
                echo "<script>alert('Curso Inserido com Sucesso!');</script>";
                $this->redirect('/cursos');
            } else {
                echo "<script>alert('Erro ao Salvar o Curso.');</script>";
                $this->redirect('/curso/incluir');
            }
        } else {
            echo "<script>alert('Nenhum arquivo enviado ou ocorreu um erro.');</script>";
            $this->redirect('/curso/incluir');
        }
    }

    public function edit($args) {
        $curso = $this->carregaDadosCurso($args['codigo']);

        if ($curso) {
            $this->render('ViewManutencaoCurso', ['curso' => $curso, 'action' => Principal::getBaseUrl() . '/curso/alterar']);
        } else {
            echo "<script>alert('Curso não encontrado.'); window.location.href = '/cursos';</script>";
        }
    }

    /**
     * Altera as Informações do Curso
     * @return void
     */
    public function update() {
        $oConexao = Database::getInstance();

        $iCodigo    = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_INT);
        $sNome      = filter_input(INPUT_POST, 'nome');
        $sDescricao = filter_input(INPUT_POST, 'descricao');

        // Verifica se foi enviado um novo arquivo de imagem
        if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
            $sNomeArquivo = basename($_FILES["imagem"]["name"]);
            $imageData    = file_get_contents($_FILES["imagem"]["tmp_name"]);
            $tipoImagem   = $_FILES["imagem"]["type"];

            $stmt = $oConexao->prepare(
                "UPDATE tbcurso" . PHP_EOL .
                "   SET curnome = :nome," . PHP_EOL .
                "       curdescricao = :descricao," . PHP_EOL .
                "       curimagem = :imagem," . PHP_EOL .
                "       curnomeimagem = :nomeImagem," . PHP_EOL .
                "       curtipoimagem = :tipoImagem" . PHP_EOL .
                " WHERE curcodigo = :codigo"
            );
            $stmt->bindParam(':nome'      , $sNome);
            $stmt->bindParam(':descricao' , $sDescricao);
            $stmt->bindParam(':imagem'    , $imageData, PDO::PARAM_LOB);
            $stmt->bindParam(':nomeImagem', $sNomeArquivo);
            $stmt->bindParam(':tipoImagem', $tipoImagem);
            $stmt->bindParam(':codigo'    , $iCodigo, PDO::PARAM_INT);
        } else {
            // Não altera a imagem se não foi enviada uma nova
            $stmt = $oConexao->prepare(
                "UPDATE tbcurso" . PHP_EOL .
                "   SET curnome = :nome," . PHP_EOL .
                "       curdescricao = :descricao" . PHP_EOL .
                " WHERE curcodigo = :codigo"
            );
            $stmt->bindParam(':nome', $sNome);
            $stmt->bindParam(':descricao', $sDescricao);
            $stmt->bindParam(':codigo', $iCodigo, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Curso alterado com sucesso!');</script>";
            $this->redirect('/cursos');
            exit;
        } else {
            echo "<script>alert('Erro ao alterar o curso.');</script>";
            // Renderiza novamente a tela de manutenção com os dados informados pelo usuário
            $aCurso = [
                'codigo'      => $iCodigo,
                'nome'        => $sNome,
                'descricao'   => $sDescricao,
            ];
            // Se o nome do arquivo foi enviado, mantém o nome atual para exibição
            if (isset($sNomeArquivo)) {
                $aCurso['nomeimagem'] = $sNomeArquivo;
            } else {
                // Busca o nome do arquivo atual no banco, se necessário
                $cursoBanco = $this->carregaDadosCurso($iCodigo);
                if (!empty($cursoBanco['nomeimagem'])) {
                    $aCurso['nomeimagem'] = $cursoBanco['nomeimagem'];
                }
            }
            $this->render('ViewManutencaoCurso', ['curso' => $aCurso]);
        }
    }

    public function delete($args) {
        $oConexao = Database::getInstance();

        // Exclui o curso do banco de dados
        $stmt = $oConexao->prepare("DELETE FROM tbcurso WHERE curcodigo = :codigo");
        $stmt->bindParam(':codigo', $args['codigo'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert(Curso Excluído com Sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao Excluir o Curso.');</script>";
        }
        $this->redirect('/cursos');
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