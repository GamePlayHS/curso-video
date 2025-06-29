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
            <a class="btn btn-success" href="<?= $base ?>/incluir-curso">Incluir Curso</a>
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
                    <tr>
                        <td>1</td>
                        <td>Curso de HTML e CSS</td>
                        <td>Aprenda a desenvolver páginas web com HTML e CSS.</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm">Alterar</button>
                            <button class="btn btn-info btn-sm">Visualizar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Curso de JavaScript</td>
                        <td>Domine a linguagem JavaScript e crie aplicações web interativas.</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm">Alterar</button>
                            <button class="btn btn-info btn-sm">Visualizar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Curso de Bootstrap</td>
                        <td>Aprenda a utilizar o framework Bootstrap para criar layouts responsivos.</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm">Alterar</button>
                            <button class="btn btn-info btn-sm">Visualizar</button>
                            <button class="btn btn-danger btn-sm">Excluir</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>