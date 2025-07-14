<?php

use core\Principal;

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Assistir Curso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            margin-bottom: 30px;
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
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
                            <?php if (!emBranco($oldVideo)): ?>
                                <a href="" id="btnAnterior" class="btn btn-primary">Anterior</a>
                            <?php else: ?>
                                <span></span>
                            <?php endif; ?>
                            <span id="videoTitulo" class="fw-bold fs-5 flex-grow-1 text-center"><?= $video['vidtitulo'] ?></span>
                            <?php if (!emBranco($newVideo)): ?>
                                <a id="btnProximo" class="btn btn-primary">Próximo</a>
                            <?php else: ?>
                                <span></span>
                            <?php endif; ?>
                        </div>
                        <div class="video-container mb-4">
                            <video id="videoPlayer" controls>
                                <source src="<?= Principal::getPathUpload() . '/' . $video['vidcaminho'] ?>"
                                    type="video/mp4">
                                Seu navegador não suporta o elemento de vídeo.
                            </video>
                        </div>
                        <?php if (isset($questionario) && $questionario): ?>
                            <div class="questionario" id="questionario">
                                <h3 class="mb-3">Questionário</h3>
                                <form id="formQuestionario" action="<?= $actionQuestionario ?>" method="post">
                                    <p class="mb-3"><?= isset($questionario['avaquestao']) ? htmlspecialchars($questionario['avaquestao']) : '' ?></p>
                                    <div class="mb-3">
                                        <label class="form-label">Alternativas</label>
                                        <?php foreach ($alternativas as $i => $alternativa):
                                            $letra = chr(65 + $i); // 65 = 'A'
                                            $checked = '';
                                            // Se o questionário já foi respondido, marca a alternativa escolhida pelo usuário
                                            if ($questionarioRespondido && $resposta['altcodigo'] == $alternativa['altcodigo']) {
                                                $checked = 'checked';
                                            }
                                        ?>
                                            <div class="input-group mb-2">
                                                <div class="input-group-text">
                                                    <input class="form-check-input mt-0" type="radio" name="resposta"
                                                        value="<?= $alternativa['altcodigo'] ?>" id="alt<?= $letra ?>"
                                                        <?= !empty($questionarioRespondido) ? 'disabled' : '' ?>
                                                        <?= $checked ?>>
                                                </div>
                                                <input type="text" class="form-control"
                                                    value="Alternativa <?= $letra ?>: <?= htmlspecialchars($alternativa['altdescricao']) ?>"
                                                    readonly>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if (empty($questionarioRespondido)): ?>
                                        <button type="submit" class="btn btn-success mt-2">Enviar Resposta</button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de erro -->
    <div class="modal fade" id="modalErroResposta" tabindex="-1" aria-labelledby="modalErroRespostaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="modalErroRespostaLabel">Atenção</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            Por favor, selecione uma alternativa antes de enviar sua resposta.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de feedback da resposta -->
    <div class="modal fade" id="modalFeedbackResposta" tabindex="-1" aria-labelledby="modalFeedbackRespostaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalFeedbackRespostaLabel"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <span id="modalFeedbackRespostaMsg"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Principal::getPathJs() ?>/ViewCursoAssistir.js"></script>
</body>

</html>