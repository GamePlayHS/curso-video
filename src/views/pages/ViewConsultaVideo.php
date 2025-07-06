<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Vídeos</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>Consulta de Vídeos</h1>
    <a href="/videos/incluir" class="btn btn-primary">Incluir Vídeo</a>
    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>URL</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($videos)): ?>
                <?php foreach ($videos as $video): ?>
                    <tr>
                        <td><?= htmlspecialchars($video['id']) ?></td>
                        <td><?= htmlspecialchars($video['titulo']) ?></td>
                        <td><?= htmlspecialchars($video['descricao']) ?></td>
                        <td><a href="<?= htmlspecialchars($video['url']) ?>" target="_blank">Assistir</a></td>
                        <td>
                            <a href="/videos/visualizar/<?= $video['id'] ?>" class="btn btn-info">Visualizar</a>
                            <a href="/videos/alterar/<?= $video['id'] ?>" class="btn btn-warning">Alterar</a>
                            <a href="/videos/excluir/<?= $video['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este vídeo?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum vídeo cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>