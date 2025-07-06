<?php

namespace src\controllers;

use \core\Controller;
use \core\Database;

class ControllerHome extends Controller {

    public function index() {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM tbcurso ORDER BY curcodigo DESC");
        $cursos = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $this->render('ViewHome', ['cursos' => $cursos]);
    }

}