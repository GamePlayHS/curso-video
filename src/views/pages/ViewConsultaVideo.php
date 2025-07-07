<?php

use core\Principal;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Vídeos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Vídeos do Curso</a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="<?= $base ?>/cursos">Cursos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Consulta de Vídeos</h1>
        <div class="mb-3">
            <a href="<?= $base ?>/curso/<?= $codigoCurso ?>/video/incluir" class="btn btn-success">Adicionar Novo Vídeo</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Duração</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($videos)): ?>
                        <?php foreach ($videos as $video): ?>
                            <tr>
                                <td><?= htmlspecialchars($video['vidcodigo']) ?></td>
                                <td><?= htmlspecialchars($video['vidtitulo']) ?></td>
                                <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= htmlspecialchars($video['viddescricao']) ?>
                                </td>
                                <td>
                                    <?= gmdate('H:i:s', $video['vidduracao']) ?>
                                </td>
                                <td class="text-center">
                                    <a href="curso/<?= $video['vidcodigo'] ?>/video/visualizar/<?= $video['vidcodigo'] ?>" class="btn btn-info btn-sm">Visualizar</a>
                                    <a href="curso/<?= $video['vidcodigo'] ?>/video/alterar/<?= $video['vidcodigo'] ?>" class="btn btn-warning btn-sm">Alterar</a>
                                    <a href="curso/<?= $video['vidcodigo'] ?>/video/excluir/<?= $video['vidcodigo'] ?>" class="btn btn-danger btn-sm btn-excluir-video">Excluir</a>
                                    <a href="curso/<?= $video['vidcodigo'] ?>/video/<?= $video['vidcodigo'] ?>/questionario" class="btn btn-danger btn-sm">Questionário</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum vídeo cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
            <!-- Paginação -->
            <?php if (!empty($videos) && isset($totalPaginas) && $totalPaginas > 1): ?>
            <nav aria-label="Navegação de páginas de vídeos">
                <ul class="pagination justify-content-center mt-4">
                    <?php
                        $paginaAtual = $paginaAtual ?? 1;
                        $paginaAnterior = max(1, $paginaAtual - 1);
                        $paginaSeguinte = min($totalPaginas, $paginaAtual + 1);
                    ?>
                    <li class="page-item <?= ($paginaAtual <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $paginaAnterior ?>">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= ($i == $paginaAtual) ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($paginaAtual >= $totalPaginas) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $paginaSeguinte ?>">Próxima</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
        </div>
    </div>

    <script src="<?= Principal::getPathJs() ?>/ViewConsultaVideo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>