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
        $this->show('product/listPost');
    }

    public function add()
    {
        $this->show('product/add');
        $this->show('product/addPost');
    }

    public function uptdatePost(){

        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price');

        $productPostModel = new Product();

        $productPostModel->setName ($name);
        $productPostModel->setDescription ($description);
        $productPostModel->setPicture ($picture);
        $productPostModel->setPrice ($price);
    }
}