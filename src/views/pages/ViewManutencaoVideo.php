<?php 
use core\Principal;
?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Novo Vídeo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gerenciar Vídeos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="mb-4 text-center">Adicionar Novo Vídeo</h2>
                        <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_video" class="form-label">Tipo Vídeo</label>
                                <select class="form-select" id="tipo_video" name="tipo_video" required>
                                    <option value="arquivo" selected>Arquivo</option>
                                    <option value="url">URL Vídeo</option>
                                </select>
                            </div>
                            <div class="mb-3" id="campo-arquivo">
                                <label for="arquivo" class="form-label">Arquivo de Vídeo</label>
                                <input type="file" class="form-control" id="arquivo" name="arquivo" accept="video/*">
                            </div>
                            <div class="mb-3 d-none" id="campo-url">
                                <label for="url" class="form-label">URL</label>
                                <input type="url" class="form-control" id="url" name="url" placeholder="https://">
                                <div class="form-text">Informe uma URL de vídeo (YouTube, Vimeo, etc.).</div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Salvar Vídeo</button>
                                <a href="<?= $base ?>/curso/<?= $codigoCurso ?>/videos"
                                    class="btn btn-secondary ms-2">Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Principal::getPathJs() ?>ViewManutencaoVideo.js"></script>
</body>

</html>