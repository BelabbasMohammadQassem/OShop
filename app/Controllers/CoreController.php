<?php

namespace App\Controllers;

abstract class CoreController
{

    // une propriété pour stocker le router (et pouvoir générer des liens avec $router->generate)
    protected $router;

    // constructeur, méthode appelée automatiquement dès que l'un des contrôleurs est instancié par AltoDispatcher
    public function __construct($router)
    {
        // on récupère le router envoyé en paramètre par AltoDispatcher
        // et on le stocke dans la propriété privée prévue à cet effet !
        $this->router = $router;
    }


    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        //global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // pour éviter d'avoir à modifier toutes les vues, 
        // on pourrait faire ça :
        // Merci Moustoifa AMADI !
        $router = $this->router;

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
         header('Location :...');
    }

    protected function checkAuthorization($roles=[]) {
        // on récupère le routeur pour générer des URL d'après les routes définies
        //global $router;
        // Si le user est connecté
        if (isset($_SESSION['userId'])) {
            // Alors on récupère l'utilisateur connecté
            $currentUser = $_SESSION['userObject'];
            
            // Puis on récupère son role
            $currentUserRole = $currentUser->getRole();
            
            // si le role fait partie des roles autorisées (fournis en paramètres)
            if (in_array($currentUserRole, $roles)) {
                // Alors on retourne vrai
                return true;
            }
            // Sinon le user connecté n'a pas la permission d'accéder à la page
            else {
                // => on envoie le header "403 Forbidden"
                http_response_code(403);
                // Puis on affiche la page d'erreur 403
                //$this->show('error/err403');
                // Enfin on arrête le script pour que la page demandée ne s'affiche pas
                exit("Erreur 403");
            }
        }
        // Sinon, l'internaute n'est pas connecté à un compte
        else {
            // Alors on le redirige vers la page de connexion
            $loginPageUrl = $this->router->generate('user-login');
            header('Location: ' . $loginPageUrl);
            exit();
        }
    }
}
