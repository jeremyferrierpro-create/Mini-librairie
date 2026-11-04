<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
   <title><?= $title ?? "Devis de commande" ?></title>
</head>
<body>
    <main class="container">
        <h1><?= $title ?? "" ?></h1>
        <p>Cette page vous permet de générer un devis récapitulatif pour vos achats de livres dans la mini-librairie.</p>

        <!-- Formulaire de commande en POST -->
        <form method="post" action="/commande">
            <label for="titre">
                Titre du livre :
                <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($data['titre'] ?? '') ?>">
            </label>

            <label for="quantite">
                Quantité :
                <input type="number" id="quantite" name="quantite" value="<?= htmlspecialchars($data['quantite'] ?? '') ?>">
            </label>

            <button type="submit">Calculer le devis</button>
        </form>

        <!-- Affichage du récapitulatif uniquement si le formulaire a été soumis -->
        <?php if (!empty($data['soumis'])): ?>
            <hr>
            <article>
                <h3>Récapitulatif de votre saisie</h3>
                <p><strong>Livre demandé :</strong> <?= htmlspecialchars($data['titre']) ?></p>
                <p><strong>Quantité :</strong> <?= htmlspecialchars($data['quantite']) ?></p>
            </article>
        <?php endif; ?>
    </main>
</body>
</html>
