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
                <?php if (!empty($data['erreurs']['titre'])): ?>
                    <small style="color: #c0392b;"><?= htmlspecialchars($data['erreurs']['titre']) ?></small>
                <?php endif; ?>
            </label>

            <label for="quantite">
                Quantité :
                <input type="number" id="quantite" name="quantite" value="<?= htmlspecialchars($data['quantite'] ?? '') ?>">
                <?php if (!empty($data['erreurs']['quantite'])): ?>
                    <small style="color: #c0392b;"><?= htmlspecialchars($data['erreurs']['quantite']) ?></small>
                <?php endif; ?>
            </label>

            <button type="submit">Calculer le devis</button>
        </form>

        <!-- Affichage du récapitulatif ou des erreurs globales -->
        <?php if (!empty($data['soumis'])): ?>
            <hr>
            <?php if (empty($data['erreurs'])): ?>
                <article>
                    <h3>Récapitulatif de votre devis</h3>
                    <p><strong>Livre demandé :</strong> <?= htmlspecialchars(trim($data['titre'])) ?></p>
                    <p><strong>Quantité :</strong> <?= htmlspecialchars($data['quantite']) ?></p>
                    <p><strong>Montant total :</strong> <?= $data['montantFormate'] ?></p>
                </article>
            <?php else: ?>
                <article style="border-left: 5px solid #c0392b;">
                    <p style="color: #c0392b; margin: 0;"><strong>Attention :</strong> Aucun devis n'a pu être généré en raison des erreurs ci-dessus.</p>
                </article>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>
