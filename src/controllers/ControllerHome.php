<?php

namespace src\controllers;

use \core\Controller;
use \core\Database;
use PDO;

class ControllerHome extends Controller {

    public function index() {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT *" . PHP_EOL .
                           "  FROM TBCURSO" . PHP_EOL .
                           " WHERE EXISTS(SELECT 1" . PHP_EOL .
                           "                FROM TBVIDEO" . PHP_EOL .
                           "               WHERE TBVIDEO.CURCODIGO = TBCURSO.CURCODIGO)" . PHP_EOL .
                           " ORDER BY curcodigo DESC");
        $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('ViewHome', ['cursos' => $cursos]);
    }

}