<?php

// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

session_start();

/* ------------
--- ROUTAGE ---
-------------*/

// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe
    ],
    'main-home'
);

// Liste des catégories
$router->map(
    'GET',
    '/category/list', // l'URL
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

// Affichage du form d'ajout de catégorie
$router->map(
    'GET',
    '/category/add', // l'URL
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add'
);

// Réception des données du form d'ajout de catégorie
$router->map(
    'POST', //! attention, le form envoie les données avec une requête POST
    '/category/add', // l'URL
    [
        'method' => 'addPost', //! une méthode différente dans le contrôleur, dans laquelle on va réceptionner les données du form (avec $_POST) et ajouter la catégorie à la BDD.
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-addPost'
);

// Affichage du form de modification de catégorie
$router->map(
    'GET',
    '/category/update/[i:id]', // l'URL
    [
        'method' => 'update',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update'
);

// Réception des données du form de modification de catégorie
$router->map(
    'POST',
    '/category/update/[i:id]', // l'URL
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-updatePost'
);

$router->map(
    'GET', 
    '/category/selectFavourite', 
    [
        'method'=>'selectFavourite', 
        'controller' =>'\App\Controllers\CategoryController'
    ],
    'category-favourite'
);

$router->map(
    'POST', 
    '/category/selectFavourite', 
    [
        'method'=>'selectFavouritePost', 
        'controller' =>'\App\Controllers\CategoryController'
    ],
    'category-favourite-post'
);

// Affichage du form d'ajout de catégorie
$router->map(
    'GET',
    '/category/delete/[i:id]', // l'URL
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-delete'
);

// Liste des produits
$router->map(
    'GET',
    '/product/list', // l'URL
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

// Affichage du form d'ajout de produit
$router->map(
    'GET',
    '/product/add', // l'URL
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

// réception du form d'ajout de produit
$router->map(
    'POST',
    '/product/add', // l'URL
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-addPost'
);

// Affichage du form de modification de produit
$router->map(
    'GET',
    '/product/update/[i:id]', // l'URL
    [
        'method' => 'update',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-update'
);

// Réception des données du form de modification de produit
$router->map(
    'POST',
    '/product/update/[i:id]', // l'URL
    [
        'method' => 'updatePost',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-updatePost'
);

// affichage du formulaire de connexion
$router->map(
    'GET',
    '/user/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login'
);

// traitement du formulaire de connexion
$router->map(
    'POST',
    '/user/login',
    [
        'method' => 'loginPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-login-post'
);

// déconnection
$router->map(
    'GET',
    '/user/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-logout'
);

// Liste des utilisateurs
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-list'
);
// formulaire d'ajout d'un utilisateur
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add'
);

// traitement de l'ajout d'un utilisateur
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'addPost',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-add-post'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

//dd($match);

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// on a besoin d'avoir accès à la variable $router un peu partout dans notre code
// on va donc l'envoyer comme paramètre lors de l'instanciation de nos contrôleurs
$dispatcher->setControllersArguments($router);

// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
