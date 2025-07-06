<?php 
use core\Principal;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-sm p-4" style="min-width: 350px; max-width: 400px; width: 100%;">
            <h2 class="mb-4 text-center">Cadastro de Usuário</h2>
            <form action="<?= $base ?>/register" method="post" id="formCadastro">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="senha" name="senha" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleSenha" tabindex="-1">
                            <span id="iconSenha" class="bi bi-eye"></span>
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="confirmar_senha" class="form-label">Confirmar Senha</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmarSenha" tabindex="-1">
                            <span id="iconConfirmarSenha" class="bi bi-eye"></span>
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary w-50 me-2">Cadastrar</button>
                    <a href="<?= $base ?>/login" class="btn btn-secondary w-50">Voltar</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Principal::getPathJs() ?>ViewUserRegister.js"></script>
</body>

</html>