<?php

namespace App\Controller;

//Import du service
use App\Service\HomeService;

class HomeController
{

    private HomeService $homeService;

    public function __construct()
    {
        //$this->homeService = $homeService;
        $this->homeService = new HomeService();
    }

    //Méthode qui retourne le template_home.php avec la méthode render
    public function home(): mixed
    {
        //Récupération du nom en GET
        $nom = $this->homeService->getNomUrl();
        //stockage dans le tableu $data
        $data["nom"] = $nom;
        //retourne le template_home.php avec les données
        return $this->render("home", "Accueil", $data);
    }

    //Méthode pour retourner la page Accueil manuel
    public function accueil(): void 
    {
        //Variable pour passer le titre au template
        $title = "Accueil";
        include __DIR__ . "/../../template/template_accueil.php";
    }

    // Méthode pour retourner la page Catalogue
    public function catalogue(): mixed 
    {
        // On récupère le filtre 'genre' s'il existe dans l'URL (ex: ?genre=Fantasy), sinon chaîne vide
        $genreFiltre = $_GET['genre'] ?? '';

        // La liste complète des livres
        $tousLesLivres = [
            [
                'titre' => 'Le Petit Prince',
                'auteur' => 'Antoine de Saint-Exupéry',
                'genre' => 'Conte'
            ],
            [
                'titre' => 'Le Hobbit',
                'auteur' => 'J. R. R. Tolkien',
                'genre' => 'Fantasy'
            ],
            [
                'titre' => 'L’Île au trésor',
                'auteur' => 'Robert Louis Stevenson',
                'genre' => 'Aventure'
            ]
        ];

        // On filtre les livres
        $livresFiltres = [];

        if (empty($genreFiltre)) {
            // Si aucun filtre, on garde tout
            $livresFiltres = $tousLesLivres;
        } else {
            // Sinon, on parcourt et on ne garde que ceux qui correspondent au genre
            foreach ($tousLesLivres as $livre) {
                if ($livre['genre'] === $genreFiltre) {
                    $livresFiltres[] = $livre;
                }
            }
        }

        // On transmet les données au template
        $data = [
            'nomLibrairie' => 'La petite librairie',
            'livres' => $livresFiltres
        ];

        return $this->render("catalogue", "Catalogue", $data);
    }

// Méthode pour afficher et traiter la page de commande
    public function commande(): mixed
    {
        // Valeurs initiales par défaut (quand on arrive en GET)
        $data = [
            'titre' => '',
            'quantite' => '',
            'erreurs' => [],
            'montantFormate' => '',
            'soumis' => false
        ];

        // Si le formulaire est soumis en POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titreBrut = $_POST['titre'] ?? '';
            $quantiteBrute = $_POST['quantite'] ?? '';

            $erreurs = [];

            // Nettoyage et validation du titre
            $titreNettoye = is_string($titreBrut) ? trim($titreBrut) : '';
            if ($titreNettoye === '') {
                $erreurs['titre'] = "Le titre est obligatoire et ne peut pas être vide ou composé uniquement d'espaces.";
            }

            // Validation de la quantité (entier de 1 à 20)
            // filter_var retourne false si ce n'est pas un entier valide ou hors limites
            $quantiteValide = filter_var($quantiteBrute, FILTER_VALIDATE_INT, [
                "options" => [
                    "min_range" => 1,
                    "max_range" => 20
                ]
            ]);

            if ($quantiteValide === false) {
                $erreurs['quantite'] = "La quantité doit être un nombre entier compris entre 1 et 20.";
            }

            // On conserve la saisie de l'utilisateur pour réafficher les champs
            $data['titre'] = $titreBrut;
            $data['quantite'] = $quantiteBrute;
            $data['soumis'] = true;
            $data['erreurs'] = $erreurs;

            // S'il n'y a aucune erreur, on calcule le montant
            if (empty($erreurs)) {
                $prixUnitaireCentimes = 1250; // 12,50 €
                $montantTotalCentimes = $quantiteValide * $prixUnitaireCentimes;
                $montantEuros = $montantTotalCentimes / 100;

                // Formatage propre du montant (ex: 37,50 €)
                $data['montantFormate'] = number_format($montantEuros, 2, ',', ' ') . ' €';
            }
        }

        return $this->render("commande", "Devis de commande", $data);
    }

    //Méthode qui va retourner les templates
    private function render(string $template, ?string $title, array $data = []): mixed
    {
        return include __DIR__ . "/../../template/template_" . $template . ".php";
    }
}