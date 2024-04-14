<?php

namespace App\Models;

// Classe mère de tous les Models
// On centralise ici toutes les propriétés et méthodes utiles pour TOUS les Models
//! on met la classe CoreModel en "abstract" (classe abstraite en français)
//! une classe abstraite NE PEUT PAS ÊTRE INSTANCIÉE !
abstract class CoreModel
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $created_at;
    /**
     * @var string
     */
    protected $updated_at;


    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of created_at
     *
     * @return  string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return  string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    //! Maintenant que notre classe est abstraire, on peut lui ajouter des méthodes abstraites !
    //! les méthodes abstraites permettent juste de déclarer la "signature" de la méthode ! (son nom, si elle est statique ou pas, si elle est public, private ou protected, et les paramètres qu'elle devra pouvoir recevoir)
    abstract public static function find($id);
    abstract public static function findAll();

    abstract public function insert();
    abstract public function update();
    abstract public function delete();
}
