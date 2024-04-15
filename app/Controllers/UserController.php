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

    public function list(){
        $appUsers = AppUser::findAll();

        //dump($categories);

        // on envoie les données à la vue
        $this->show('user/list', [
            'appUsers' => $appUsers
            
        ]);
       $this->checkAuthorization();
       
    }

    public function update(){
        $updateUsers = AppUser::findAll();

        //dump($categories);

        // on envoie les données à la vue
        $this->show('user/list', [
            'updateUsers' => $updateUsers
            
        ]);
       $this->checkAuthorization();
       
    }
}