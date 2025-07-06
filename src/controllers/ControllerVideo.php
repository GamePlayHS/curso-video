<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use PDO;

class ControllerVideo extends Controller {

    public function index() {
        $oConexao = Database::getInstance();
        $stmt = $oConexao->query("SELECT * FROM tbvideo ORDER BY vidcodigo DESC");
        $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renderiza a view de consulta de vídeos, passando os vídeos encontrados
        $this->render('ViewConsultaVideo', ['videos' => $videos]);
    }

    public function show($args) {
        // Lógica para exibir um vídeo específico
    }

    public function create() {
        // Lógica para exibir formulário de criação de vídeo
    }

    public function store($args) {
        // Lógica para salvar um novo vídeo
    }

    public function edit($args) {
        // Lógica para exibir formulário de edição de vídeo
    }

    public function update($args) {
        // Lógica para atualizar um vídeo existente
    }

    public function delete($args) {
        // Lógica para deletar um vídeo
    }
}