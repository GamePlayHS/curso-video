<?php

namespace Src\Controllers;

use core\Controller;
use core\Database;
use core\Principal;
use PDO;

class ControllerUsuario extends Controller {

    public function index() {
        $this->render('ViewRegisterUsuario');
    }

    public function register() {
        $nome  = htmlspecialchars(filter_input(INPUT_POST, 'nome'));
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = htmlspecialchars(filter_input(INPUT_POST, 'senha'));

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

    public function dadosCadastrais() {
        // Busca o usuário logado na sessão
        if (isset($_SESSION['usuario']['codigo'])) {
            $this->render('ViewUsuario', [
                'usuario' => $_SESSION['usuario'],
                'action' => Principal::getBaseUrl() . '/usuario/dadosCadastrais'
            ]);
            return;
        }
        // Se não encontrar, redireciona para login
        $_SESSION['error'] = 'Usuário não encontrado. Faça login novamente.';
        $this->redirect('/login');
    }

    public function atualizaDadosCadastrais() {
        $nome  = htmlspecialchars(filter_input(INPUT_POST, 'nome'));
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, 'senha');

        if ($nome && $email) {
            $db = Database::getInstance();

            if (!empty($senha)) {
                // Atualiza nome, email e senha
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE tbusuario SET usunome = :nome, usuemail = :email, ususenha = :senha WHERE usucodigo = :id");
                $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
                $stmt->bindParam(':id', $_SESSION['usuario']['codigo'], PDO::PARAM_INT);
            } else {
                // Atualiza apenas nome e email
                $stmt = $db->prepare("UPDATE tbusuario SET usunome = :nome, usuemail = :email WHERE usucodigo = :id");
                $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':id', $_SESSION['usuario']['codigo'], PDO::PARAM_INT);
            }

            if ($stmt->execute()) {
                $_SESSION['usuario']['nome'] = $nome;
                $_SESSION['usuario']['email'] = $email;
                $_SESSION['success'] = 'Dados atualizados com sucesso.';
                $this->redirect('/');
            } else {
                $_SESSION['error'] = 'Erro ao atualizar dados. Tente novamente.';
                $this->redirect('/');
            }
        } else {
            $_SESSION['error'] = 'Dados inválidos. Por favor, tente novamente.';
            $this->redirect('/usuario/dadosCadastrais');
        }
    }

}