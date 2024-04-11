<?php

namespace App\Controllers;

use App\Models\Product;

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
        $this->show('product/add');
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
            header("Location: " + $this->router->generate('product-list'));
            exit;
        } else {
            die("Erreur lors de l'ajout d'un produit.");
        }
    }
}