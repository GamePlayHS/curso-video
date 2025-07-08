<?php 
use core\Principal;
?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= isset($video) ? 'Alterar Vídeo' : 'Adicionar Novo Vídeo' ?></title>
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
                        <h2 class="mb-4 text-center"><?= isset($video) ? 'Alterar Vídeo' : 'Adicionar Novo Vídeo' ?></h2>
                        <form action="<?= $action ?? '#' ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required
                                    value="<?= isset($video) ? htmlspecialchars($video['vidtitulo']) : '' ?>"
                                    <?= isset($visualizacao) && $visualizacao ? 'readonly disabled' : '' ?>>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" required
                                    <?= isset($visualizacao) && $visualizacao ? 'readonly disabled' : '' ?>><?= isset($video) ? htmlspecialchars($video['viddescricao']) : '' ?></textarea>
                            </div>
                            <?php if (!isset($visualizacao) || !$visualizacao): ?>
                                <div class="mb-3" id="campo-arquivo">
                                    <label for="arquivo" class="form-label">Arquivo de Vídeo (.mp4)</label>
                                    <input type="file" class="form-control" id="arquivo" name="arquivo" accept=".mp4"
                                        <?= (isset($video) && (!isset($visualizacao) || !$visualizacao)) ? '' : 'disabled' ?> <?= isset($video) ? '' : 'required' ?>>
                                    <div class="form-text text-danger" id="arquivo-erro" style="display:none;">Apenas arquivos .mp4 são permitidos.</div>
                                    <?php if (isset($video) && !empty($video['vidcaminho'])): ?>
                                        <div class="form-text">
                                            Vídeo atual: <a href="<?= Principal::getBaseUrl() . '/uploads/' . $video['vidcaminho'] ?>" target="_blank"><?= htmlspecialchars(basename($video['vidcaminho'])) ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($video) && !empty($video['vidcaminho'])): ?>
                                <div class="mb-4">
                                    <label class="form-label">Visualizar Vídeo</label>
                                    <video width="100%" height="340" controls>
                                        <source src="<?= Principal::getBaseUrl() . '/uploads/' . $video['vidcaminho'] ?>" type="video/mp4">
                                        Seu navegador não suporta a tag de vídeo.
                                    </video>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-end">
                                <?php if (!isset($visualizacao) || !$visualizacao): ?>
                                    <button type="submit" class="btn btn-success"><?= isset($video) ? 'Salvar Alterações' : 'Salvar Vídeo' ?></button>
                                <?php endif; ?>
                                <a href="<?= $base ?>/curso/<?= $codigoCurso ?>/videos" class="btn btn-secondary ms-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('arquivo').addEventListener('change', function () {
            const input = this;
            const erro = document.getElementById('arquivo-erro');
            if (input.files.length > 0) {
                const file = input.files[0];
                const ext = file.name.split('.').pop().toLowerCase();
                if (ext !== 'mp4') {
                    erro.style.display = 'block';
                    input.value = '';
                } else {
                    erro.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>