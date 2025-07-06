<?php

namespace Src\Controllers;

use core\Controller;

class ControllerUserRegister extends Controller {

    public function index() {
        $this->render('ViewUserRegister');
    }

    public function register() {
        // Lógica para processar o registro do usuário
        $nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        if ($nome && $email && $senha) {
            // Aqui você deve adicionar a lógica para salvar o usuário no banco de dados
            // Exemplo: UserModel::create($nome, $email, $senha);

            // Redireciona para a página de login ou sucesso
            $this->redirect('/login');
        } else {
            // Se os dados forem inválidos, redireciona de volta com uma mensagem de erro
            $_SESSION['error'] = 'Dados inválidos. Por favor, tente novamente.';
            $this->redirect('/register');
        }
    }
    
}