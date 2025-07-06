<?php 
use core\Principal;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN (para o ícone do olho) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-sm p-4" style="min-width: 350px; max-width: 400px; width: 100%;">
            <h2 class="mb-4 text-center">Login</h2>
            <?php if (isset($loginInvalido) && $loginInvalido): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Login inválido!</strong> E-mail ou senha incorretos.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>
            <form method="post" action="<?= $base ?>/login">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
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
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary w-50 me-2">Entrar</button>
                    <a href="<?= $base ?>/register" class="btn btn-secondary w-50">Cadastrar</a>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Principal::getPathJs() ?>ViewLogin.js"></script>
</body>
</html>