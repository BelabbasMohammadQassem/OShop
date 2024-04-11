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
            'categories' => $categories
        ]);
    }

    public function add()
    {
        $this->show('category/add');
    }

    // méthode qui réceptionne le form d'ajout
    public function addPost()
    {
        //global $router;
        // dd($_POST);

        if(isset($_POST['name'])) {
            $name = $_POST['name'];
        } else {
            die("Erreur, le champ Nom est manquant !");
        }

        if(isset($_POST['subtitle'])) {
            $subtitle = $_POST['subtitle'];
        } else {
            die("Erreur, le champ sous-titre est manquant !");
        }
        
        // on peut utiliser filter_input à la place de isset+$_POST
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);

        //! Actuellement, notre code est vulnérable à la faille XSS ! (injection de code javascript)
        //* Pour s'en prémunir, on doit "nettoyer" les champs du formulaire !
        //* On peut utiliser un filtre particulier avec filter_input et le filtre FILTER_SANITIZE_SPECIAL_CHARS
        //* Mais on peut aussi utiliser htmlentities() ou htmlspecialchars()
        $name = htmlspecialchars($name);
        $subtitle = htmlspecialchars($subtitle);
        //$picture = htmlspecialchars($picture);

        if(is_null($picture)) {
            // si picture est null, c'est que le champ n'était pas présent
            die("Erreur, le champ image est manquant !");
        }


        // validation des données du form (vérifier la longueur, vérifier si l'URL de l'image est bien correcte, etc.)

        // TODO : améliorer la validation, avec par exemple un tableau d'erreurs qui serait renvoyé & affiché sur le formulaire en cas d'erreurs

        if(strlen($name) < 3) {
            // erreur !
            die("Le nom doit contenir au moins 3 caractères !");
        }

        if(strlen($subtitle) < 5) {
            // erreur !
            die("Le sous-titre doit contenir au moins 5 caractères !");
        }

        if(!str_starts_with($picture, 'http://') && !str_starts_with($picture, 'https://')) {
            die("L'URL de l'image n'est pas correcte !");
        }

        // on veut ajouter une catégorie en BDD
        // vu qu'on bosse avec des objets, on instancie la classe Category
        $category = new Category();

        // on remplit notre objet
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);

        // on demande à notre objet de s'insérer en BDD
        // si l'ajout s'est bien passé, on redirige vers la liste !
        if($category->insert()) {
            // insert() a renvoyé true, on redirige !
            //header('Location: /product/list');
            // c'est mieux avec $router->generate() !
            header("Location: " . $this->router->generate('category-list'));
            exit;
        } else {
            die("Erreur lors de l'ajout d'une catégorie.");
        }
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
}