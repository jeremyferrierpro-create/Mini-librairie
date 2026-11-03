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
        // 1. On récupère le filtre 'genre' s'il existe dans l'URL (ex: ?genre=Fantasy), sinon chaîne vide
        $genreFiltre = $_GET['genre'] ?? '';

        // 2. La liste complète des livres
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

        // 3. On filtre les livres
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

        // 4. On transmet les données au template
        $data = [
            'nomLibrairie' => 'La Petite Librairie',
            'livres' => $livresFiltres
        ];

        return $this->render("catalogue", "Catalogue", $data);
    }

    //Méthode qui va retourner les templates
    private function render(string $template, ?string $title, array $data = []): mixed
    {
        return include __DIR__ . "/../../template/template_" . $template . ".php";
    }
}