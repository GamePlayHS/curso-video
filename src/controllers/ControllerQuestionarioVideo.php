<?php

namespace Src\Controllers;

use core\Controller;

class ControllerQuestionarioVideo extends Controller {

    public function show($args) {
        $this->render('ViewManutencaoQuestionario', [
            'titulo' => 'Incluir Questionário',
            'codigoCurso' => $args['curso'],
            'codigoVideo' => $args['video'],
            'action' => '/questionario/incluir',
            'visualizacao' => false,
        ]);
    }

}
