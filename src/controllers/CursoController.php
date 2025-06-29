<?php

namespace Src\Controllers;

use core\Controller;

class CursoController extends Controller {

    public function index() {
        $this->render('gerenciar-cursos');
    }

    public function show($id) {
        // Mostra detalhes de um curso específico
    }

    public function create() {
        // Exibe formulário para criar um novo curso
    }

    public function store($data) {
        // Salva um novo curso
    }

    public function edit($id) {
        // Exibe formulário para editar um curso existente
    }

    public function update($id, $data) {
        // Atualiza um curso existente
    }

    public function destroy($id) {
        // Remove um curso
    }

}