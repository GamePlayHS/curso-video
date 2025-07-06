<?php
namespace src\controllers;

use \core\Controller;

class ControllerHome extends Controller {

    public function index() {
        $this->render('ViewHome');
    }

}