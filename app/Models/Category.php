<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     * findAll() est une méthode STATIQUE, ça veut dire qu'on peut l'appeler SANS devoir instancier d'objet
     * les méthodes STATIQUES sont des méthodes liées à la classe, et pas à un objet spécifique !
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Méthode permettant de récupérer les 3 premiers enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findFirstThree()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category` LIMIT 3';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }

    public static function updateAllHomepage($listCategories){

        $pdo = Database::getPDO();
        //On remets l'ordre des toutes les catégories à 0 puis on update les 5 catégories du formulaire (avec une requête préparé)
        $sql = 'Update category set home_order=0 Where 1; Update category set home_order=1 Where id=:id_category1; Update category set home_order=2 Where id=:id_category2; Update category set home_order=3 Where id=:id_category3; Update category set home_order=4 Where id=:id_category4; Update category set home_order=5 Where id=:id_category5';
        $req = $pdo->prepare($sql); 
        //On donne toutes les id de catégories provenant du formulaire (dans l'ordre correspondant à home_order)
        $req->execute([
            'id_category1'=> $listCategories[0], 
            'id_category2'=> $listCategories[1], 
            'id_category3'=> $listCategories[2], 
            'id_category4'=> $listCategories[3], 
            'id_category5'=> $listCategories[4], 
        ]);
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table category
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        $sql = "
            INSERT INTO `category` (name, subtitle, picture) 
            VALUES ('$this->name', '$this->subtitle', '$this->picture')
        ";

        //! ATTENTION, la requête ci-dessus est vulnérable aux injections SQL ...
        //* pour s'en prémunir, on doit utiliser des REQUÊTES PRÉPARÉES

        // on écrit la requête
        $sql = "INSERT INTO `category` (name, subtitle, picture) 
                VALUES (:name, :subtitle, :picture)";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':subtitle', $this->subtitle);
        $stmt->bindParam(':picture', $this->picture);

        // on lance la requête avec execute()
        // qui renvoit true si tout s'est bien passé, false sinon !
        if ($stmt->execute()) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table category
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "
            UPDATE `category`
            SET
                name = :name,
                subtitle = :subtitle,
                picture = :picture,
                updated_at = NOW()
            WHERE id = :id
        ";

        // on prépare la requête
        $stmt = $pdo->prepare($sql);

        // on "bind" (associe) nos paramètres
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':subtitle', $this->subtitle);
        $stmt->bindParam(':picture', $this->picture);
        $stmt->bindParam(':id', $this->id);


        // on execute la requête et on renvoit true ou false
        return $stmt->execute();
    }

    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();


        $sql = "DELETE FROM category WHERE id = {$this->id}";


        $delete = $pdo->exec($sql);


        return $delete;
    }

}
