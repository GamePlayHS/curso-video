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
                <ul class="navbar-nav ms-auto"> <!-- Alinhando o botão à direita -->
                    <li class="nav-item">
                        <a class="btn btn-primary" href="<?= $base ?>/gerenciar-cursos">Gerenciar Cursos</a><!-- Botão de gerenciamento -->
                    </li>
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
            <div class="col-md-4 course-item">
                <div class="card">
                    <img src="curso1.jpg" class="card-img-top" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title">Curso de HTML e CSS</h5>
                        <p class="card-text">Aprenda a desenvolver páginas web com HTML e CSS.</p>
                        <a href="#" class="btn btn-primary">Ver Curso</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 course-item">
                <div class="card">
                    <img src="curso2.jpg" class="card-img-top" alt="Curso 2">
                    <div class="card-body">
                        <h5 class="card-title">Curso de JavaScript</h5>
                        <p class="card-text">Domine a linguagem JavaScript e crie aplicações web interativas.</p>
                        <a href="#" class="btn btn-primary">Ver Curso</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 course-item">
                <div class="card">
                    <img src="curso3.jpg" class="card-img-top" alt="Curso 3">
                    <div class="card-body">
                        <h5 class="card-title">Curso de Bootstrap</h5>
                        <p class="card-text">Aprenda a utilizar o framework Bootstrap para criar layouts responsivos.
                        </p>
                        <a href="#" class="btn btn-primary">Ver Curso</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= Principal::getPathJs() ?>home.js"></script>
</body>

</html>