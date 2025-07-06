<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use PDO;

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
            $db = Database::getInstance();
            $stmt = $db->prepare("SELECT * FROM tbusuario WHERE usuemail = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['ususenha'])) {
                // Autenticação bem-sucedida, inicia a sessão
                $_SESSION['usuario'] = [
                    'usucodigo' => $usuario['usucodigo'],
                    'usunome'   => $usuario['usunome'],
                    'usuemail'  => $usuario['usuemail']
                ];
                $this->redirect('/');
            }
        }
        // Se os dados forem inválidos, redireciona de volta com uma mensagem de erro
        $this->redirect('/loginInvalido');
    }

    public function logout() {
        // Lógica de logout
    }
}