<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    public function list()
    {
        // on a besoin de la liste des catégories
        // donc, on instancie le modèle correspondant
        //$categoryModel = new Category();
        // et on utilise sa méthode findAll() pour récupérer tous les enregistrements
        //$categories = $categoryModel->findAll();

        // maintenant que la méthode findAll est statique, on peut directement faire :
        $categories = Category::findAll();

        //dump($categories);

        // on envoie les données à la vue
        $this->show('category/list', [
            'categories' => $categories, 
            'csrfToken' => $_SESSION['token']
        ]);
    }

    public function add()
    {
        // vu qu'on pré-rempli le form en cas d'erreur, il nous faut une catégorie vide !
        $category = new Category();

        $this->show('category/add', [
            "category" => $category, 
            'csrfToken' => $_SESSION['token']
        ]);
    }

    // méthode qui réceptionne le form d'ajout
    public function addPost()
    {
        // on récupère les données avec filter_input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);

        // validation des données du form (vérifier la longueur, vérifier si l'URL de l'image est bien correcte, etc.)
        // un tableau d'erreurs qui sera renvoyé & affiché sur le formulaire en cas d'erreurs
        $errors = [];

        if(is_null($name)) {
            // si name est null, c'est que le champ n'était pas présent
            //die("Erreur, le champ nom est manquant !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Erreur, le champ nom est manquant !";
        }

        if(is_null($subtitle)) {
            // si subtitle est null, c'est que le champ n'était pas présent
            // die("Erreur, le champ sous-titre est manquant !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Erreur, le champ sous-titre est manquant !";
        }

        if(is_null($picture)) {
            // si picture est null, c'est que le champ n'était pas présent
            // die("Erreur, le champ image est manquant !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Erreur, le champ image est manquant !";
        }

        if(mb_strlen($name) < 3) {
            // erreur !
            //die("Le nom doit contenir au moins 3 caractères !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Le nom doit contenir au moins 3 caractères !";
        }

        if(mb_strlen($name) > 64) {
            // erreur !
            //die("Le nom doit contenir au moins 3 caractères !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Le nom doit contenir moins de 64 caractères !";
        }

        if(mb_strlen($subtitle) < 5) {
            // erreur !
            //die("Le sous-titre doit contenir au moins 5 caractères !");

            // on ajoute le message d'erreur au tableau
            $errors[] = "Le sous-titre doit contenir au moins 5 caractères !";
        }

        if(mb_strlen($subtitle) > 64) {
            // erreur !
            //die("Le nom doit contenir au moins 3 caractères !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Le sous-titre doit contenir moins de 64 caractères !";
        }

        if(!str_starts_with($picture, 'http://') && !str_starts_with($picture, 'https://')) {
            // erreur !
            //die("L'URL de l'image n'est pas correcte !");

            // on ajoute le message d'erreur au tableau
            $errors[] = "L'URL de l'image n'est pas correcte !";
        }

        // on veut ajouter une catégorie en BDD
        // vu qu'on bosse avec des objets, on instancie la classe Category
        $category = new Category();

        // on remplit notre objet
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);


        // on vérifie s'il y a eu une erreur ou pas !
        if(empty($errors)) {
            // le tableau d'erreur est vide, donc on ajoute en BDD !

            // on demande à notre objet de s'insérer en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if($category->insert()) {
                // insert() a renvoyé true, on redirige !
                //header('Location: /product/list');
                // c'est mieux avec $router->generate() !
                header("Location: " . $this->router->generate('category-list'));
                exit;
            } else {
                //die("Erreur lors de l'ajout d'une catégorie.");
                $errors[] = "Erreur lors de l'ajout d'une catégorie.";
            }
        }

        // si on arrive à cet endroit là, c'est forcément qu'il y a eu une erreur !
        // on réaffiche le form d'ajout de catégorie, et on lui envoie notre tableau d'erreurs !
        // on renvoit également l'objet category pré-rempli avec les données du form, pour que l'utilisateur n'ait pas à tout retaper !
        $this->show('category/add', [
            'errors' => $errors,
            'category' => $category
        ]);
    }

    public function update($id)
    {
        // on veut pré-remplir le form avec les données de la catégorie, 
        // donc on doit récupérer ces données ! (avec un Category::find())
        $category = Category::find($id);

        //dump($category);

        $this->show('category/update', [
            'category' => $category
        ]);
    }

    // pour réceptionner le form de modification
    public function updatePost($id)
    {
        //dump($id);
        //dd($_POST);   

        // on récupère les données
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);


        // (facultatif) validation des données
        // TODO

        // sur update, on veut MODIFIER UN OBJET EXISTANT, donc on le recupère !
        $category = Category::find($id);

        // on met à jour cet objet avec les données récupèrées dans le form
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);

        // on demande à l'objet de se sauvegarder
        if($category->update()) {
            // update() a renvoyé true, on redirige !
            header("Location: " . $this->router->generate('category-list'));
            exit;
        } else {
            die("Erreur lors de la modification de la catégorie.");
        }
        
    }
    /**
     *  
     *
     * @return void
     */
    public function selectFavourite(){
        
        $allCategories = Category::findAll();
        $this->show('category/selectFavouriteCategory', [
            'listCategories'=>$allCategories, 
            'csrfToken'=> $_SESSION['token']
        ]);
    }

    public function selectFavouritePost(){
        $homeOrders = (filter_input_array(INPUT_POST))['emplacement'];
        Category::updateAllHomepage($homeOrders);
        header("Location: " . $this->router->generate('main-home'));
        exit();
    }
    public function delete($id){
        $category = new Category($id);
        $category->delete();
        header("Location: " . $this->router->generate('category-list'));
        exit();
    }
}