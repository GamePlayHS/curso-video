<?php 
use core\Principal;
?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Assistir Curso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; margin-bottom: 30px; }
        .video-container video { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    </style>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="mb-4 text-center"><?= $curso['curnome'] ?></h2>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button id="btnAnterior" class="btn btn-primary" onclick="navegar(-1)">Anterior</button>
                        <span id="videoTitulo" class="fw-bold fs-5"><?= $video['vidtitulo'] ?></span>
                        <button id="btnProximo" class="btn btn-primary" onclick="navegar(1)">Próximo</button>
                    </div>
                    <div class="video-container mb-4">
                        <video id="videoPlayer" controls> <source src="<?= Principal::getDiretorioUpload() . $video['vidcaminho'] ?>" type="video/mp4">
                            Seu navegador não suporta o elemento de vídeo.
                        </video>
                    </div>
                    <div class="questionario" id="questionario">
                        <h3 class="mb-3"><?= $questionario['avaquestao'] ?></h3>
                        <form>
                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resposta" value="a" id="altA">
                                    <label class="form-check-label" for="altA">Alternativa A</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resposta" value="b" id="altB">
                                    <label class="form-check-label" for="altB">Alternativa B</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resposta" value="c" id="altC">
                                    <label class="form-check-label" for="altC">Alternativa C</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="resposta" value="d" id="altD">
                                    <label class="form-check-label" for="altD">Alternativa D</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success mt-2" onclick="enviarResposta()">Enviar Resposta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>