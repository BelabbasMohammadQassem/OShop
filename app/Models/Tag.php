<?php

namespace App\Models;

use PDO;
use App\Utils\Database;
use App\Models\CoreModel;

/**
 * Représente la table SQL tag
 * et les enregistrements de cette table
 */

class Tag extends CoreModel
{
    /**
     * @var string Nom du tag
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table tag en fonction d'un id donné
     * 
     * @param int $tagId ID dutag
     * @return Tag
     */
    public static function find($tagId)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `tag`
            WHERE id = :id
        ';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':id', $tagId, PDO::PARAM_INT);
        
        $success = $pdoStatement->execute();

        if($success) {
            return $pdoStatement->fetchObject(self::class);
        }
        
        return false;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag
     * 
     * @return Tag[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `tag`';
        $pdoStatement = $pdo->query($sql);
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function insert()
    {
        //@TODO

    }

    public function update()
    {
        //@TODO
    }

    public function delete()
    {
        //@TODO
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag, liée à l'ID produit fourni
     * 
     * @param int $productId L'ID du produit
     * @return Tag[]
     */
    public static function findAllByProductId(int $productId)
    {
        // PDO
        $pdo = Database::getPDO();
        // Requête
        $sql = "
            SELECT tag.*
            FROM product_has_tag
            INNER JOIN tag ON product_has_tag.tag_id = tag.id
            WHERE product_has_tag.product_id = :product_id
        ";
        // On prépare, on exécute
        $pdoStatement = $pdo->prepare($sql);
        // On associe les valeurs
        $pdoStatement->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $pdoStatement->execute();
        // On fetch
        return $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Ajoute un tag à un produt
     * L'association est enregistrée dans la table de pivot product_has_tag
     * 
     * @param int $productId
     * @return bool
     */
    public function addToProduct(int $productId)
    {
        $sql = '
            INSERT INTO `product_has_tag` (
                `product_id`,
                `tag_id`
            ) VALUES (
                :product_id,
                :tag_id
            )
        ';
        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $pdoStatement->bindValue(':tag_id', $this->getId(), PDO::PARAM_INT);
        $success = $pdoStatement->execute();

        return $success;
    }

    /**
     * Retire un tag à un produt
     * 
     * @param int $productId
     * @return bool
     */
    public function removeFromProduct(int $productId)
    {
        $sql = '
            DELETE FROM `product_has_tag`
            WHERE
                product_id = :product_id
                AND tag_id = :tag_id
        ';
        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $pdoStatement->bindValue(':tag_id', $this->getId(), PDO::PARAM_INT);

        $success = $pdoStatement->execute();

        return $success;
    }

    /**
     * Get nom du tag
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nom du tag
     *
     * @param  string  $name  Nom du tag
     */ 
    public function setName(string $name)
    {
        $this->name = $name;
    }
}