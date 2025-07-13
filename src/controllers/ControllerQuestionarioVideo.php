<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use PDO;

class ControllerQuestionarioVideo extends Controller {

    public function show($args) {
        $oConexao = Database::getInstance();
        $iCodigoCurso = $args['curso'];
        $iCodigoVideo = $args['video'];

        // Busca o questionário do vídeo, se existir
        $stmt = $oConexao->prepare("SELECT * FROM tbavaliacao WHERE curcodigo = :curso AND vidcodigo = :video");
        $stmt->bindValue(':curso', $iCodigoCurso, PDO::PARAM_INT);
        $stmt->bindValue(':video', $iCodigoVideo, PDO::PARAM_INT);
        $stmt->execute();
        $oQuestionario = $stmt->fetch(PDO::FETCH_ASSOC);

        $aAlternativas = [];
        $iCorreta = 1;

        if ($oQuestionario) {
            // Busca as alternativas do questionário
            $stmtAlt = $oConexao->prepare("SELECT * FROM tbalternativa WHERE avacodigo = :codigo ORDER BY altcodigo ASC");
            $stmtAlt->bindValue(':codigo', $oQuestionario['avacodigo'], PDO::PARAM_INT);
            $stmtAlt->execute();
            $alternativasBanco = $stmtAlt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($alternativasBanco as $index => $alt) {
                $aAlternativas[$index] = $alt['altdescricao'];
                if ($alt['altcorreta']) {
                    $iCorreta = $index + 1;
                }
            }
        }

        $sAction = '/curso/' . $iCodigoCurso . '/video/' . $iCodigoVideo . '/questionario';
        if ($oQuestionario) {
            $sTitulo = 'Alterar Questionário';
            $sAction .= '/alterar';
        } else {
            $sTitulo = 'Incluir Questionário';
            $sAction .= '/inserir';
        }

        $this->render('ViewManutencaoQuestionario', [
            'titulo'       => $sTitulo,
            'codigoCurso'  => $iCodigoCurso,
            'codigoVideo'  => $iCodigoVideo,
            'action'       => $sAction,
            'questionario' => $oQuestionario,
            'alternativas' => $aAlternativas,
            'correta'      => $iCorreta
        ]);
    }

    public function inserir($args) {
        $oConexao = Database::getInstance();

        $sQuestao      = filter_input(INPUT_POST, 'questao', FILTER_SANITIZE_STRING);
        $iCurso        = $args['curso'];
        $iVideo        = $args['video'];
        $aAlternativas = isset($_POST['alternativa']) ? $_POST['alternativa'] : [];
        $iCorreta      = filter_input(INPUT_POST, 'correta', FILTER_VALIDATE_INT);

        // Insere um novo questionário
        $stmt = $oConexao->prepare("INSERT INTO tbavaliacao (curcodigo, vidcodigo, avaquestao) VALUES (:curso, :video, :questao)");
        $stmt->bindValue(':curso'  , $iCurso  , PDO::PARAM_INT);
        $stmt->bindValue(':video'  , $iVideo  , PDO::PARAM_INT);
        $stmt->bindValue(':questao', $sQuestao, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $iAvaliacao = $oConexao->lastInsertId();
    
            // Insere as alternativas
            if (is_array($aAlternativas)) {
                foreach ($aAlternativas as $iIndex => $sDescricao) {
                    $sDescricaoAlternativa = filter_var($sDescricao, FILTER_SANITIZE_STRING);
                    $bCorreta = ($iCorreta == ($iIndex + 1)) ? 1 : 0;
                    $stmt = $oConexao->prepare("INSERT INTO tbalternativa (avacodigo, vidcodigo, curcodigo, altdescricao, altcorreta) VALUES (:avaliacao, :video, :curso, :descricao, :correta)");
                    $stmt->bindValue(':avaliacao', $iAvaliacao           , PDO::PARAM_INT);
                    $stmt->bindValue(':curso'    , $iCurso               , PDO::PARAM_INT);
                    $stmt->bindValue(':video'    , $iVideo               , PDO::PARAM_INT);
                    $stmt->bindValue(':descricao', $sDescricaoAlternativa, PDO::PARAM_STR);
                    $stmt->bindValue(':correta'  , $bCorreta             , PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            $this->redirect('/curso/' . $iCurso . '/videos');
        }
    }

    public function alterar($args) {
        $oConexao      = Database::getInstance();
        $iAvaliacao    = filter_input(INPUT_POST, 'codigo' , FILTER_VALIDATE_INT);
        $sQuestao      = filter_input(INPUT_POST, 'questao', FILTER_SANITIZE_STRING);
        $iCurso        = $args['curso'];
        $iVideo        = $args['video'];
        $aAlternativas = isset($_POST['alternativa']) ? $_POST['alternativa'] : [];
        $iCorreta      = filter_input(INPUT_POST, 'correta', FILTER_VALIDATE_INT);

        // Atualiza o questionário existente
        $stmt = $oConexao->prepare("UPDATE tbavaliacao SET avaquestao = :questao WHERE avacodigo = :codigo");
        $stmt->bindValue(':questao', $sQuestao  , PDO::PARAM_STR);
        $stmt->bindValue(':codigo' , $iAvaliacao, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            // Exclui todas as alternativas anteriores
            $stmt = $oConexao->prepare("DELETE FROM tbalternativa WHERE avacodigo = :codigo and vidcodigo = :video and curcodigo = :curso");
            $stmt->bindValue(':codigo', $iAvaliacao, PDO::PARAM_INT);
            $stmt->bindValue(':video' , $iVideo, PDO::PARAM_INT);
            $stmt->bindValue(':curso' , $iCurso, PDO::PARAM_INT);
            $stmt->execute();
    
            // Insere novamente as alternativas
            if (is_array($aAlternativas)) {
                foreach ($aAlternativas as $index => $texto) {
                    $sDescricaoAlternativa = filter_var($texto, FILTER_SANITIZE_STRING);
                    $ehCorreta = ($iCorreta == ($index + 1)) ? 1 : 0;
                    $stmt = $oConexao->prepare("INSERT INTO tbalternativa (avacodigo, vidcodigo, curcodigo, altdescricao, altcorreta) VALUES (:codigo, :video, :curso, :descricao, :correta)");
                    $stmt->bindValue(':codigo'   , $iAvaliacao           , PDO::PARAM_INT);
                    $stmt->bindValue(':video'    , $iVideo               , PDO::PARAM_INT);
                    $stmt->bindValue(':curso'    , $iCurso               , PDO::PARAM_INT);
                    $stmt->bindValue(':descricao', $sDescricaoAlternativa, PDO::PARAM_STR);
                    $stmt->bindValue(':correta'  , $ehCorreta            , PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
            $this->redirect('/curso/' . $iCurso . '/videos');
        } else {
            // Se falhar, redireciona de volta com erro
            $this->redirect('/curso/' . $iCurso . '/videos');
        }
    }

}
