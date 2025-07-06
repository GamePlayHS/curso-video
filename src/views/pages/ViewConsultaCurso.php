<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciar Cursos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Gerenciar Cursos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Lista de Cursos</h2>

        <!-- Botão "Incluir Curso" -->
        <div class="d-flex justify-content-start mb-3">
            <a class="btn btn-success" href="<?= $base ?>/curso/incluir">Incluir Curso</a>
        </div>

        <!-- Grid de cursos com Bootstrap -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome do Curso</th>
                        <th>Descrição</th> <!-- Alterado de "Categoria" para "Descrição" -->
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                        <tr>
                            <td><?= $curso['curcodigo'] ?></td>
                            <td style="max-width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $curso['curnome'] ?></td>
                            <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= $curso['curdescricao'] ?></td>
                            <td style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" class="text-center">
                                <a href="<?= $base ?>/curso/alterar/<?= $curso['curcodigo'] ?>" class="btn btn-warning btn-sm">Alterar</button>
                                <a href="<?= $base ?>/curso/visualizar/<?= $curso['curcodigo'] ?>" class="btn btn-info btn-sm">Visualizar</button>
                                <a href="<?= $base ?>/curso/excluir/<?= $curso['curcodigo'] ?>" class="btn btn-danger btn-sm">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    <nav aria-label="Navegação de página de cursos">
        <ul class="pagination justify-content-center mt-4">
            <?php
                // Página anterior
                $paginaAnterior = max(1, $paginaAtual - 1);
                // Página seguinte
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>