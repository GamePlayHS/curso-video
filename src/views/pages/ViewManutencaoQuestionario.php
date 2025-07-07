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

                            <!-- Fieldset Questionário -->
                            <fieldset class="border rounded-3 p-3 mb-3">
                                <legend class="float-none w-auto px-2">Questionário</legend>
                                <div class="mb-3">
                                    <label for="questao" class="form-label">Questão</label>
                                    <textarea class="form-control" id="questao" name="questao" rows="2" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alternativas</label> 
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <div class="input-group mb-2">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="radio" name="correta" value="<?= $i ?>" <?= $i === 1 ? 'checked' : '' ?> required title="Marque como correta">
                                            </div>
                                            <input type="text" class="form-control" name="alternativa[]" placeholder="Alternativa <?= $i ?>" maxlength="255" required>
                                        </div>
                                    <?php endfor; ?>
                                    <div class="form-text">Selecione qual alternativa é a correta.</div>
                                </div>
                            </fieldset>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Salvar Vídeo</button>
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