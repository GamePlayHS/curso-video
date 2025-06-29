<?php 
use core\Principal;
?><!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Incluir Curso</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Incluir Curso</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Cadastro de Curso</h2>

        <form action="<?= $base ?>/incluir-curso" method="POST" enctype="multipart/form-data">
            <!-- Nome do Curso -->
            <div class="mb-3">
                <label for="cursoNome" class="form-label">Nome do Curso</label>
                <input type="text" class="form-control" id="cursoNome" name="cursoNome" required>
            </div>

            <!-- Descrição -->
            <div class="mb-3">
                <label for="cursoDescricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="cursoDescricao" name="cursoDescricao" rows="4" maxlength="255" required></textarea>
            </div>

            <!-- Imagem do Curso -->
            <div class="mb-3">
                <label for="cursoImagem" class="form-label">Imagem do Curso</label>
                <input type="file" class="form-control" id="cursoImagem" name="cursoImagem" accept=".png, .jpg" required>
            </div>


            <!-- Botões de ação -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Salvar</button>
                <button type="reset" class="btn btn-secondary ms-2">Limpar</button>
            </div>
        </form>
    </div>

    <script src="<?= Principal::getPathJs() ?>incluir-curso.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>