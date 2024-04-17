<?php

namespace App\Controllers;

use App\Models\Type;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

class ProductController extends CoreController
{
    public function list()
    {
        // on a besoin de la liste de produits
        // on la récupère avec la méthode statique findAll() du modèle Product
        $products = Product::findAll();

        $this->show('product/list', [
            'products' => $products
        ]);
    }

    public function add()
    {
        // vu qu'on pré-rempli le form en cas d'erreur, il nous faut un produit vide !
        $product = new Product();

        // dans le form, on a besoin de la liste des catégories, marques & types pour remplir les selects
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();

        $this->show('product/form', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types
        ]);
    }

    // méthode qui réceptionne le form d'ajout
    public function addPost()
    {
        global $router;
        //dd($_POST);

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_SPECIAL_CHARS);

        // TODO : validation des données du form (vérifier la longueur, vérifier si l'URL de l'image est bien correcte, etc.)

        // on veut ajouter un produit en BDD
        // vu qu'on bosse avec des objets, on instancie la classe Product
        $product = new Product();

        // on remplit notre objet
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setBrandId($brand_id);
        $product->setTypeId($type_id);
        $product->setCategoryId($category_id);

        // on demande à notre objet de s'insérer en BDD
        // si l'ajout s'est bien passé, on redirige vers la liste !
        if($product->insert()) {
            // insert() a renvoyé true, on redirige !
            //header('Location: /product/list');
            // c'est mieux avec $router->generate() !
            header("Location: " . $this->router->generate('product-list'));
            exit;
        } else {
            die("Erreur lors de l'ajout d'un produit.");
        }
    }

    // TODO (bonus) : essayer de faire une seule méthode pour l'affichage et la réception du form
    //* indice : il faudra arriver à déterminer à l'intérieur si on est en GET, ou en POST !

    // affichage du form de modification de produit
    public function update($id)
    {
        // on récupère le produit à modifier
        $product = Product::find($id);

        // on a également besoin de la liste des catégories, des marques et des types de produit pour remplir les select !
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();

        $productTags = Tag::findAllByProductId($id);

        $this->show('product/form', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types,
            'productTags' => $productTags,
        ]);
    }

    /**
     * Crée une association entre un tag  et un produit
     */
    public function addTag()
    {
        $tagId = filter_input(INPUT_POST, 'tag_id', FILTER_VALIDATE_INT);
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

        //!on ne peux ajouter un tag à un produit que si un $tagId et un $productId sont définis
        if($tagId && $productId) {
            //!récupération du tag grace à son id
            $tag = Tag::find($tagId);

            //!on ajoute le tag au produit demandé
            if($tag->addToProduct($productId)) {
                //!on redirige sur la page d'édition du produit si tout s'est bien passé
                global $router;
                header('Location: ' . $router->generate('product-update', ['id' => $productId]));
            }
        }
        
        //!s'il y a une erreur, il faudrait afficher un message adéquat
        echo 'ERREUR AJOUT TAG A UN PRODUIT';
        echo __FILE__.':'.__LINE__; exit();
    }

    /**
     * Retire l'association d'un tag pour un produit
     */
    public function removeTag($productId, $tagId)
    {
        if($tagId) {
            //!on récupère le tag dans la couche modèle
            $tag = Tag::find($tagId);
            if($tag->removeFromProduct($productId)) {
                //!si la suppression du tag pour le produit demandé s'est bien passé, on redirige sur la page d'édition
                global $router;
                header('Location: ' . $router->generate('product-update', ['id' => $productId]));
                exit();
            }
        }

        //!il faudrait afficher un message d'erreur ici
        echo 'ERREUR SUPPRESION TAG D\'UN PRODUIT';
        echo __FILE__.':'.__LINE__; exit();
    }

    // réception du form de modif de produit
    public function updatePost($id)
    {
        // on récupère les données avec filter_input
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_SPECIAL_CHARS);
        //$productTags = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_SPECIAL_CHARS);

        // validation des données du form (vérifier la longueur, vérifier si l'URL de l'image est bien correcte, etc.)
        // un tableau d'erreurs qui sera renvoyé & affiché sur le formulaire en cas d'erreurs
        $errors = [];

        if(is_null($name)) {
            // si name est null, c'est que le champ n'était pas présent
            //die("Erreur, le champ nom est manquant !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Erreur, le champ nom est manquant !";
        }

        if(mb_strlen($name) < 3) {
            // erreur !
            //die("Le nom doit contenir au moins 3 caractères !");

            // on ajoute le message d'erreur au tableau !
            $errors[] = "Le nom doit contenir au moins 3 caractères !";
        }

        // TODO : compléter la validation des données pour le produit
        

        // on veut mettre à jour le produit, donc on le récupère !
        $product = Product::find($id);

        // on remplit notre objet
        $product->setName($name);
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setBrandId($brand_id);
        $product->setTypeId($type_id);
        $product->setCategoryId($category_id);

        // on vérifie s'il y a eu une erreur ou pas !
        if(empty($errors)) {
            // le tableau d'erreur est vide, donc on met à jour en BDD !

            // on demande à notre objet de se mettre à jour en BDD
            // si l'ajout s'est bien passé, on redirige vers la liste !
            if($product->update()) {
                // update() a renvoyé true, on redirige !
                header("Location: " . $this->router->generate('product-list'));
                exit;
            } else {
                //die("Erreur lors de l'ajout d'une catégorie.");
                $errors[] = "Erreur lors de la modification du produit.";
            }
        }

        // si on arrive à cet endroit là, c'est forcément qu'il y a eu une erreur !
        // on réaffiche le form de modification de produit, et on lui envoie notre tableau d'erreurs !
        // on renvoit également l'objet produit pré-rempli avec les données du form, pour que l'utilisateur n'ait pas à tout retaper !
        // on a également besoin de la liste des catégories, des marques et des types de produit pour remplir les select !
        $categories = Category::findAll();
        $brands = Brand::findAll();
        $types = Type::findAll();

        $this->show('product/form', [
            'errors' => $errors,
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types
        ]);
    }
}