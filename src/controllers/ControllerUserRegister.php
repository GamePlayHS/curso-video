<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;

class ControllerUserRegister extends Controller {

    public function index() {
        $this->render('ViewUserRegister');
    }

    public function register() {
        $nome  = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        if ($nome && $email && $senha) {
            // Conexão com o banco
            $db = Database::getInstance();

            // Hash da senha para segurança
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Inserção na tabela tbusuario
            $stmt = $db->prepare("INSERT INTO tbusuario (usunome, usuemail, ususenha) VALUES (:nome, :email, :senha)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senhaHash);

            if ($stmt->execute()) {
                $this->redirect('/login');
            } else {
                $_SESSION['error'] = 'Erro ao cadastrar usuário. Tente novamente.';
                $this->redirect('/register');
            }
        } else {
            $_SESSION['error'] = 'Dados inválidos. Por favor, tente novamente.';
            $this->redirect('/register');
        }
    }
    
}