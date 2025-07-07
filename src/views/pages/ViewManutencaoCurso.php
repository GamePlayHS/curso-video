<?php 
use core\Principal;

// Verifica se está em modo visualização
$visualizacao = isset($visualizacao) && $visualizacao === true;
?><!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Curso</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Curso</a>
        </div>
    </nav>

    <div class="container mt-4">
        <form action="<?= $action ?? '#' ?>" method="POST" enctype="multipart/form-data">
            <!-- Campo oculto para o código do curso -->
            <?php if (isset($curso['curcodigo'])): ?>
                <input type="hidden" name="codigo" value="<?= htmlspecialchars($curso['curcodigo']) ?>">
            <?php endif; ?>

            <!-- Nome do Curso -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Curso</label>
                <input type="text" class="form-control" id="nome" name="nome" maxlength="100" required value="<?= $curso['curnome'] ?? '' ?>" <?= $visualizacao ? 'disabled' : '' ?>>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" required <?= $visualizacao ? 'disabled' : '' ?>><?= $curso['curdescricao'] ?? '' ?></textarea>
            </div>

            <!-- Imagem do Curso -->
            <?php if (!$visualizacao): ?>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem do Curso</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept=".png, .jpg" <?= $visualizacao ? 'disabled' : '' ?>>
                <div class="form-text text-danger" id="imagem-erro" style="display:none;">Apenas arquivos .jpg e .png são permitidos.</div>
                <?php if (isset($curso['curnomeimagem'])): ?>
                    <small class="text-muted">Arquivo atual: <?= htmlspecialchars($curso['curnomeimagem']) ?></small>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Botões de ação -->
            <div class="d-flex justify-content-end">
                <?php if (!$visualizacao): ?>
                <button type="submit" class="btn btn-success">Confirmar</button>
                <button type="reset" class="btn btn-secondary ms-2">Limpar</button>
                <?php endif; ?>
                <div class="d-flex justify-content-end">
                    <a href="<?= $base ?>/cursos" class="btn btn-primary ms-2">Voltar</a>
                </div>
            </div>
        </form>
    </div>

    <script src="<?= Principal::getPathJs() ?>/ViewManutencaoCurso.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>