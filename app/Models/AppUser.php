<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel {

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $role;

    /**
     * @var int
     */
    private $status;

    /**
     * Méthode permettant la récupération d'un model en base
     */
    public static function find($userId)
    {
        // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
        // se connecter à la BDD
        $pdo = Database::getPDO();

         // écrire notre requête
         $sql = '
         SELECT *
         FROM app_user
         WHERE id = ' . $userId;
        

          // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

           // un seul résultat => fetchObject
           $result = $pdoStatement->fetchObject('App\Models\AppUser');

             // retourner le résultat
        return $result;


    }

    /**
     * Méthode permettant la récupération de tous les models en base
     */
    public static function findAll()
    {
        // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel

        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\AppUser');

        return $results;
    }
    
    /**
     * Récupérer un utilisateur via son e-mail
     */
    public static function findByEmail($email)
    {
        // récupération de la connexion à la BDD => objet PDO
        $pdo = Database::getPDO();

        // requête SQL
        $sql = '
        SELECT * 
        FROM app_user
        WHERE email = :email';

        // on utilise prepare() car $email vient d'une saisie de l'utilisateur => Pas confiance !
        $pdoStatement = $pdo->prepare($sql);
        // on exécute la requête en donnant à PDO la valeur à utiliser pour remplacer ':email'
        $pdoStatement->execute([':email' => $email]);
        // on récupère le résultat sous la forme d'un objet de la classe AppUser
        $result = $pdoStatement->fetchObject('App\Models\AppUser');
        
        // on renvoie le résultat
        return $result;
    }

    /**
     * Méthode permettant la création du model en base
     */
    public function insert()
    {
        // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
    }

    /**
     * Méthode permettant la mise à jour du model en base
     */
    public function update()
    {
        // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
        
      
            // Récupération de l'objet PDO représentant la connexion à la DB
            $pdo = Database::getPDO();
    
            // Ecriture de la requête UPDATE
            $sql = "
                UPDATE `user`
                SET
                    name = '{$this->lastname}',
                    updated_at = NOW()
                WHERE id = {$this->id}
            ";
    
            // Execution de la requête de mise à jour (exec, pas query)
            $updatedRows = $pdo->exec($sql);
    
            // On retourne VRAI, si au moins une ligne ajoutée
            return ($updatedRows > 0);
        
    
    }

    /**
     * Méthode permettant la suppression du model en base
     */
    public function delete()
    {
        // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
    }




      /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     */ 
    public function setPassword(string $password)
    {
        $this->password =  password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     */ 
    public function setRole(string $role)
    {
        $this->role = $role;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;
    }
}