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
        // Définition du tableau $data avec les données à transmettre
        $data = [
            'nomLibrairie' => 'La Petite Librairie',
            'livres' => [
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
            ]
        ];

        return $this->render("catalogue", "Catalogue", $data);
    }

    //Méthode qui va retourner les templates (Celle-ci manquait !)
    private function render(string $template, ?string $title, array $data = []): mixed
    {
        return include __DIR__ . "/../../template/template_" . $template . ".php";
    }
}