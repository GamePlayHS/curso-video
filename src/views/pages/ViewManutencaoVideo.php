<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vídeo</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; }
        h1 { text-align: center; color: #333; }
        .video-list { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .video-list th, .video-list td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        .video-list th { background: #f0f0f0; }
        .actions button { margin-right: 8px; }
        .add-video { display: block; margin: 20px 0; text-align: right; }
        .add-video a { background: #28a745; color: #fff; padding: 10px 18px; border-radius: 4px; text-decoration: none; }
        .add-video a:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vídeo</h1>
        <div class="add-video">
            <a href="/videos/novo">Adicionar Novo Vídeo</a>
        </div>
        <table class="video-list">
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
                <!-- Exemplo de linha de vídeo, substitua pelo loop PHP -->
                <tr>
                    <td>1</td>
                    <td>Exemplo de Vídeo</td>
                    <td>Descrição do vídeo exemplo.</td>
                    <td><a href="https://youtu.be/exemplo" target="_blank">Assistir</a></td>
                    <td class="actions">
                        <button onclick="window.location.href='/videos/editar/1'">Editar</button>
                        <button onclick="if(confirm('Deseja excluir este vídeo?')) window.location.href='/videos/excluir/1'">Excluir</button>
                    </td>
                </tr>
                <!-- Fim do exemplo -->
                <?php if (!empty($videos)): ?>
                    <?php foreach ($videos as $video): ?>
                        <tr>
                            <td><?= htmlspecialchars($video['id']) ?></td>
                            <td><?= htmlspecialchars($video['titulo']) ?></td>
                            <td><?= htmlspecialchars($video['descricao']) ?></td>
                            <td><a href="<?= htmlspecialchars($video['url']) ?>" target="_blank">Assistir</a></td>
                            <td class="actions">
                                <button onclick="window.location.href='/videos/editar/<?= $video['id'] ?>'">Editar</button>
                                <button onclick="if(confirm('Deseja excluir este vídeo?')) window.location.href='/videos/excluir/<?= $video['id'] ?>'">Excluir</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">Nenhum vídeo cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>