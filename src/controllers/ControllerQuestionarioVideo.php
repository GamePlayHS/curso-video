<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;

class ControllerQuestionarioVideo extends Controller {

    public function show($args) {
        $oConexao = Database::getInstance();
        $codigoCurso = $args['curso'];
        $codigoVideo = $args['video'];

        // Busca o questionário do vídeo, se existir
        $stmt = $oConexao->prepare("SELECT * FROM tbquestionario WHERE curcodigo = :curso AND vidcodigo = :video");
        $stmt->bindValue(':curso', $codigoCurso, \PDO::PARAM_INT);
        $stmt->bindValue(':video', $codigoVideo, \PDO::PARAM_INT);
        $stmt->execute();
        $questionario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($questionario) {
            // Se existe, trata como alteração
            $titulo = 'Alterar Questionário';
            $visualizacao = false;
            $action = '/questionario/alterar/' . $questionario['quescodigo'];
        } else {
            // Se não existe, trata como inclusão
            $titulo = 'Incluir Questionário';
            $visualizacao = false;
            $action = '/questionario/incluir';
        }

        $this->render('ViewManutencaoQuestionario', [
            'titulo' => $titulo,
            'codigoCurso' => $codigoCurso,
            'codigoVideo' => $codigoVideo,
            'action' => $action,
            'visualizacao' => $visualizacao,
            'questionario' => $questionario
        ]);
    }

}
