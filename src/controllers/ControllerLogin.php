<?php

namespace Src\Controllers;

use core\Controller;

class ControllerLogin extends Controller {

    public function index() {
        $loginInvalido = false;
        if (strpos($_SERVER['REQUEST_URI'], 'loginInvalido') !== false) {
            $loginInvalido = true;
        }
        $this->render('ViewLogin', ['loginInvalido' => $loginInvalido]);
    }

    public function login() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        if ($email && $senha) {
            // Aqui você deve adicionar a lógica para autenticar o usuário
            // Exemplo: UserModel::authenticate($email, $senha);

            // Se a autenticação for bem-sucedida, redireciona para a página inicial
            $this->redirect('/');
        }
        // Se os dados forem inválidos, redireciona de volta com uma mensagem de erro
        $this->redirect('/loginInvalido');
    }

    public function logout() {
        // Lógica de logout
    }
}