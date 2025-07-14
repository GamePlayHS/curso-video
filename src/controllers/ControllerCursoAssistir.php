<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use core\Principal;
use PDO;

class ControllerCursoAssistir extends Controller {

    public function index($args) {
        $iCurso = $args['curso'];
        $iVideo = $args['video'] ?? null;

        $aCurso        = $this->getCurso($iCurso);
        $aVideo        = $this->getVideo($iCurso, $iVideo);
        $aProximoVideo = $this->getVideo($iCurso, ($iVideo ?? 1) + 1);
        $aAvaliacao    = $this->getQuestionario($aVideo);
        $aAlternativas = $this->getAlternativas($aAvaliacao);
        $aResposta     = $this->getRespostaQuestionario($aAvaliacao);

        $sOldVideo = '';
        $sNewVideo = '';

        /* Verifica se deve retornar ao vídeo anterior. */
        if (!emBranco($iVideo) && $iVideo > 1) {
            $sOldVideo = Principal::getBaseUrl() . '/curso/' . $iCurso . '/' . ($iVideo - 1) . '/assistir';
        }

        /* Verifica se deve ir para o próximo vídeo. */
        if (!emBranco($iVideo) && $aProximoVideo) {
            $sNewVideo = Principal::getBaseUrl() . '/curso/' . $iCurso . '/' . $aProximoVideo['vidcodigo'] . '/assistir';
        }

        $this->render('ViewCursoAssistir', [
            'titulo'                 => 'Assistir Curso',
            'curso'                  => $aCurso,
            'video'                  => $aVideo,
            'questionario'           => $aAvaliacao,
            'alternativas'           => $aAlternativas,
            'resposta'               => $aResposta,
            'newVideo'               => $sNewVideo,
            'oldVideo'               => $sOldVideo,
            'questionarioRespondido' => $aResposta !== false,
            'actionQuestionario'     => Principal::getBaseUrl() . '/curso/' . $iCurso . '/' . $aVideo['vidcodigo'] . '/resposta'
        ]);
    }

    /**
     * Retorna o Curso
     * @param int $iCurso
     * @return array
     */
    protected function getCurso($iCurso) {
        $oConexao = Database::getInstance();
        $stmt = $oConexao->prepare("SELECT * FROM tbcurso WHERE curcodigo = :curso");
        $stmt->bindValue(':curso', $iCurso, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna o Vídeo
     * @param int $iCurso
     * @param int $iVideo
     * @return array
     */
    protected function getVideo($iCurso, $iVideo) {
        $oConexao = Database::getInstance();
        if (empty($iVideo)) {
            /* Carrega o primeiro vídeo identificado para o Curso. */
            $stmt = $oConexao->prepare("SELECT * FROM tbvideo WHERE curcodigo = :curso ORDER BY vidcodigo ASC LIMIT 1");

            /* Define os Parâmetros do SQL. */
            $stmt->bindValue(':curso', $iCurso, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
        $stmt = $oConexao->prepare("SELECT * FROM tbvideo WHERE curcodigo = :curso AND vidcodigo = :video");

        /* Define os Parâmetros do SQL. */
        $stmt->bindValue(':curso', $iCurso, PDO::PARAM_INT);
        $stmt->bindValue(':video', $iVideo, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna o Questionário do Vídeo
     * @param array $oVideo
     * @return array
     */
    protected function getQuestionario($oVideo) {
        $oConexao = Database::getInstance();
        $stmt = $oConexao->prepare("SELECT * FROM tbavaliacao WHERE curcodigo = :curso AND vidcodigo = :video");

        /* Define os Parâmetros do SQL. */
        $stmt->bindValue(':curso', $oVideo['curcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':video', $oVideo['vidcodigo'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna as Alternativas do Questionário
     * @param array $oAvaliacao
     * @return array
     */
    protected function getAlternativas($oAvaliacao) {
        $oConexao = Database::getInstance();
        $stmt = $oConexao->prepare("SELECT *" . PHP_EOL .
                                   "  FROM tbalternativa" . PHP_EOL .
                                   " WHERE curcodigo = :curso" . PHP_EOL .
                                   "   AND vidcodigo = :video" . PHP_EOL .
                                   "   AND avacodigo = :avaliacao");

        /* Define os Parâmetros do SQL. */
        $stmt->bindValue(':curso'    , $oAvaliacao['curcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':video'    , $oAvaliacao['vidcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':avaliacao', $oAvaliacao['avacodigo'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna a resposta do questionário feito pelo usuário
     * @param array $aAvaliacao
     * @return array
     */
    protected function getRespostaQuestionario($aAvaliacao) {
        $oConexao = Database::getInstance();
        $stmt = $oConexao->prepare("SELECT *" . PHP_EOL .
                                   "  FROM tbresposta" . PHP_EOL .
                                   " WHERE curcodigo = :curso" . PHP_EOL .
                                   "   AND vidcodigo = :video" . PHP_EOL .
                                   "   AND avacodigo = :avaliacao");

        /* Define os Parâmetros do SQL. */
        $stmt->bindValue(':curso'    , $aAvaliacao['curcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':video'    , $aAvaliacao['vidcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':avaliacao', $aAvaliacao['avacodigo'], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ====================================================================================================================================================================================================================== */
    /* ==================================================================================================== MÉTODOS AJAX ==================================================================================================== */
    /* ====================================================================================================================================================================================================================== */

    public function processaRespostaQuestionario($args) {
        // Recebe os dados enviados via AJAX
        $iCurso = $args['curso'];
        $iVideo = $args['video'];
        $altcodigo = filter_input(INPUT_POST, 'resposta', FILTER_VALIDATE_INT);

        header('Content-Type: application/json');

        if (empty($altcodigo)) {
            echo json_encode(['correta' => false, 'mensagem' => 'Nenhuma resposta selecionada.']);
            exit;
        }

        $oConexao = Database::getInstance();

        // Busca a alternativa marcada e verifica se é correta
        $stmt = $oConexao->prepare("SELECT altcorreta FROM tbalternativa WHERE altcodigo = :altcodigo AND curcodigo = :curso AND vidcodigo = :video");
        $stmt->bindValue(':altcodigo', $altcodigo, PDO::PARAM_INT);
        $stmt->bindValue(':curso', $iCurso, PDO::PARAM_INT);
        $stmt->bindValue(':video', $iVideo, PDO::PARAM_INT);
        $stmt->execute();
        $alternativa = $stmt->fetch(PDO::FETCH_ASSOC);

        $bCorreta = isset($alternativa['altcorreta']) && $alternativa['altcorreta'] == 1;

        // Salva a resposta do usuário (exemplo, ajuste conforme sua lógica de usuário)
        // Exemplo: $_SESSION['usuario']['codigo']
        if (isset($_SESSION['usuario']['codigo'])) {
            $iUsuario = $_SESSION['usuario']['codigo'];

            // Busca o código da avaliação
            $stmtAva = $oConexao->prepare("SELECT avacodigo FROM tbavaliacao WHERE curcodigo = :curso AND vidcodigo = :video");
            $stmtAva->bindValue(':curso', $iCurso, PDO::PARAM_INT);
            $stmtAva->bindValue(':video', $iVideo, PDO::PARAM_INT);
            $stmtAva->execute();

            $aAvaliacao = $stmtAva->fetch(PDO::FETCH_ASSOC);

            if ($aAvaliacao) {
                // Remove resposta anterior, se existir
                $stmtDel = $oConexao->prepare("DELETE FROM tbresposta WHERE usucodigo = :usuario AND curcodigo = :curso AND vidcodigo = :video AND avacodigo = :avaliacao");
                $stmtDel->bindValue(':usuario', $iUsuario, PDO::PARAM_INT);
                $stmtDel->bindValue(':curso', $iCurso, PDO::PARAM_INT);
                $stmtDel->bindValue(':video', $iVideo, PDO::PARAM_INT);
                $stmtDel->bindValue(':avaliacao', $aAvaliacao['avacodigo'], PDO::PARAM_INT);
                $stmtDel->execute();

                // Insere nova resposta
                $stmtIns = $oConexao->prepare("INSERT INTO tbresposta (usucodigo, curcodigo, vidcodigo, avacodigo, altcodigo) VALUES (:usuario, :curso, :video, :avaliacao, :altcodigo)");
                $stmtIns->bindValue(':usuario', $iUsuario, PDO::PARAM_INT);
                $stmtIns->bindValue(':curso', $iCurso, PDO::PARAM_INT);
                $stmtIns->bindValue(':video', $iVideo, PDO::PARAM_INT);
                $stmtIns->bindValue(':avaliacao', $aAvaliacao['avacodigo'], PDO::PARAM_INT);
                $stmtIns->bindValue(':altcodigo', $altcodigo, PDO::PARAM_INT);
                $stmtIns->execute();
            }
        }

        echo json_encode(['correta' => $bCorreta]);
        exit;
    }

}
