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

    public function addpost() {
    
    $name = filter_input(INPUT_POST, 'name');
    $subtitle = filter_input(INPUT_POST, 'subtitle');
    $picture = filter_input(INPUT_POST, 'picture');
     dump($_POST);
      
        $categoriePostModel = new Category();

     $categoriePostModel->setName ($name);
     $categoriePostModel->setSubtitle ($subtitle);
     $categoriePostModel->setPicture ($picture);

     dump($categoriePostModel);

    }

  



    public function uptdatePost(){
        $this->show('Product/Add');
    }
    
   
}