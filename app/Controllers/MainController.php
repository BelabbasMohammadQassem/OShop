<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // on récupère les 3 premières catégories & les 3 premiers produits
        $products = Product::findFirstThree();
        $categories = Category::findFirstThree();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}