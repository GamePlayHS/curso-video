<?php 
use core\Principal;
?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Cursos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Cursos Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if (!empty($_SESSION['usuario'])): ?>
                        <li class="nav-item me-2">
                            <span class="navbar-text text-white">
                                Bem-vindo, <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong>!
                            </span>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="btn btn-primary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Ações
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if (!empty($_SESSION['usuario']['gestor']) && $_SESSION['usuario']['gestor']): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $base ?>/cursos">Gerenciar Cursos</a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $base ?>/usuario/dadosCadastrais">Dados Cadastrais</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= $base ?>/logout">Sair</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Cursos Disponíveis</h2>

        <!-- Campo de busca -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar cursos..." onkeyup="filterCourses()">
        </div>

        <div class="row" id="coursesContainer">
            <?php if (!empty($cursos)): ?>
                <?php foreach ($cursos as $curso): ?>
                    <div class="col-md-4 course-item mb-4">
                        <div class="card h-100">
                            <img src="data:image/jpeg;base64,<?= $curso['curimagem'] ?>" class="card-img-top" alt="<?= htmlspecialchars($curso['curnome']) ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($curso['curnome']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($curso['curdescricao']) ?></p>
                                <a href="<?= $base ?>/curso/<?= $curso['curcodigo'] ?>/assistir" class="btn btn-primary mt-auto">Ver Curso</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Nenhum curso disponível no momento.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Principal::getPathJs() ?>/ViewHome.js"></script>
</body>

</html>