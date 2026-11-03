<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= $title ?? "" ?></title>
</head>
<body>
<main class="container">
        <h1><?= $title ?? "" ?></h1>
        <p>Bienvenue dans <?= htmlspecialchars($data['nomLibrairie'] ?? 'la mini-librairie') ?></p>

        <?php if (!empty($data['livres'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Genre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['livres'] as $livre): ?>
                        <tr>
                            <td><?= htmlspecialchars($livre['titre']) ?></td>
                            <td><?= htmlspecialchars($livre['auteur']) ?></td>
                            <td><?= htmlspecialchars($livre['genre']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun livre à afficher.</p>
        <?php endif; ?>
    </main>
</body>
</html>
