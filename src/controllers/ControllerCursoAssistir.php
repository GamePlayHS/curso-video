<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use PDO;

class ControllerCursoAssistir extends Controller {

    public function index($args) {
        $iCurso = $args['curso'];
        $iVideo = $args['video'] ?? null;

        $aCurso        = $this->getCurso($iCurso);
        $aVideo        = $this->getVideo($iCurso, $iVideo);
        $aAvaliacao    = $this->getQuestionario($aVideo);
        $aAlternativas = $this->getAlternativas($aAvaliacao);

        $this->render('ViewCursoAssistir', [
            'titulo'       => 'Assistir Curso',
            'curso'        => $aCurso,
            'video'        => $aVideo,
            'questionario' => $aAvaliacao,
            'alternativas' => $aAlternativas
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
            $stmt->bindValue(':curso', $iCurso, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }
        $stmt = $oConexao->prepare("SELECT * FROM tbvideo WHERE curcodigo = :curso AND vidcodigo = :video");
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
        $stmt = $oConexao->prepare("SELECT * FROM tbalternativa WHERE curcodigo = :curso AND vidcodigo = :video AND avacodigo = :avaliacao");
        $stmt->bindValue(':curso'    , $oAvaliacao['curcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':video'    , $oAvaliacao['vidcodigo'], PDO::PARAM_INT);
        $stmt->bindValue(':avaliacao', $oAvaliacao['avacodigo'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}