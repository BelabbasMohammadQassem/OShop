<?php

namespace App\Controllers;

use App\Models\AppUser;
/**
 * Contrôleur pour gérer les pages et les actions liées aux utilisateurs
 */
class UserController extends CoreController {

    /**
     * Afficher le formulaire de connexion
     */
    public function login()
    {
        $this->show('user/login');
    }

    /**
     * Prise en charge de la soumission du formulaire de connexion (route POST)
     */
    public function loginPost()
    {
        // on récupère l'utilisateur qui correspond à l'email entré par l'utilisateur
        $sanitizedEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $user = AppUser::findByEmail($sanitizedEmail);
        
        // si l'utilisateur n'a pas été trouvé, $user vaudra false
        if ($user === false) {
            exit('Utilisateur ou mot de passe incorrect');
        }

        // si le mot de passe fourni via le formulaire (POST) et le mot de passe provenant de la base de données ($user) correspondent,
        // c'est que l'utilisateur a fourni un couple email/mot de passe valide !
        if(password_verify($_POST['password'], $user->getPassword())){
        //if ($user->getPassword() === $_POST['password']) {

            // on enregistre les infos de l'utilisateur en sesssion, pour persister son état "connecté" d'une page à l'autre
            // l'id de l'utilisateur...
            $_SESSION['userId'] = $user->getId();
            // ...ainsi que l'objet complet
            $_SESSION['userObject'] = $user;

            // On affiche un message de joie et d'allégresse
            //echo "OK ! You did it !";
            header("Location:" . $this->router->generate('main-home'));
            exit();
        }
        // sinon, c'est qu'un mot de passe ne correspondant pas à l'email a été fourni
        else {
            exit('Utilisateur ou mot de passe incorrect');
        }
    }

    public function logout(){
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);

        //session_destroy();
        header("Location:" . $this->router->generate('user-login'));
        
    }

     /**
     * Lister les utilisateurs du backoffice
     */
    public function list()
    {
        $this->checkAuthorization(['admin']);
        // cette page est réservée aux administrateurs
        //$this->checkAuthorization(['admin']);

        // pour afficher la liste des utilisateurs, il nous faut... les données des utilisateurs. Hé oui.
        $userList = AppUser::findAll();
        
        $this->show('user/list', [
            'userList' => $userList
        ]);
    }

     /**
     * Page d'ajout d'un utilisateur
     */
    public function add()
    {
        // cette page est réservée aux administrateurs
        $this->checkAuthorization(['admin']);

        $this->show('user/add', [
            'csrfToken'=> $_SESSION['token']
        ]);
    }

    /**
     * Traitement du formulaire d'ajout
     */
    public function addPost()
    {
        // on vérifie que l'utilisateur a le droit d'envoyer des données sur cette route !
        $this->checkAuthorization(['admin']);

        //on récupère le routeur pour générer des URL
        global $router;

        /* ----------------
           -- VALIDATION --
           ---------------- */
        // avant d'utiliser les données saisies par l'utilisateur, on les valide
        // on prévoit un array pour contenir les erreurs, pour les traiter toutes en une fois ensuite
        $errors = [];

        /* 
            --- On vérifie que tous les champs on été remplis ---
        */

        // filter_input() permet de faire des vérifications sur des données externes (ici sur $_POST)
        // https://www.php.net/manual/fr/function.filter-input.php
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $passwordConfirm = filter_input(INPUT_POST, 'password-confirm');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $role = filter_input(INPUT_POST, 'role');
        $status = filter_input(INPUT_POST, 'status');
        
        // si un champ au moins n'est pas renseigné, on ajoute un message d'erreur
        // ici on pourrait faire un peu mieux en vérifiant chaque champ, pour ajuster le message en fonction du champ
        if (!$email || !$password || !$passwordConfirm || !$firstname || !$lastname || !$role || !$status)  {
            $errors[] = 'Tous les champs sont obligatoires';
        }

        /* 
            --- On vérifie la validité de certains champs sur des critères plus particuliers ---
        */
        // il faut d'abord vérifier que l'email est valide, c'est à dire contient bien "@", puis un nom de domaine... bref, a bien une forme d'email, quoi.
        // on utilise filter_var() pour vérifier la validité de l'email. Si l'email est valide, filter_var() renvoie la valeur, false sinon
        // voir https://www.php.net/manual/fr/function.filter-var.php
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        // si l'email n'est pas valide
        if ($email === false) {
            // on stocke un message d'erreur
            $errors[] = 'Le format de l\'email n\'est pas valide.';
        }
        // puis vérifier que le mot de passe correspond à la confirmation
        if ($_POST['password'] === $_POST['password-confirm']) {
            $password = $_POST['password'];
        } else {
            $errors[] = 'La confirmation du mot de passe doit être identique au mot de passe saisi.';
        }
        
        // puis vérifier que le mot de passe contient suffisamment de caractères
        // on utilise strlen() qui permet d'obtenir la longueur d'une chaîne
        // https://www.php.net/manual/fr/function.strlen.php
        if (strlen($password) < 8) {
            $errors[] = 'Le mot de passe doit contenir au moins 8 caractères.';
        }

        // ici, on veut empêcher la fonction de continuer normalement si une erreur a eu lieu, 
        // c'est à dire si le tableau $errors n'est pas vide
        if (count($errors) > 0) {
            // on affiche les erreurs rencontrées
            dump($errors);
            exit();
        }

        /* --------------------
           -- ENREGISTREMENT --
           -------------------- */

        // on crée le model et on renseigne les valeurs des propriétés via les setters
        $newUser = new AppUser;
        $newUser->setEmail($email);
        $newUser->setPassword($password);
        $newUser->setFirstname($firstname);
        $newUser->setLastname($lastname);
        $newUser->setRole($role);
        $newUser->setStatus($status);

        // on sauvegarde le model
        $newUser->insert();
        
        // on redirige sur la page de liste
        $listPageUrl = $router->generate('user-list');
        header('Location: ' . $listPageUrl);
        exit();
    }

    
}