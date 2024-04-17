<?php

namespace App\Models;

use App\Utils\Database;

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
    }

    /**
     * Méthode permettant la récupération de tous les models en base
     */
    public static function findAll()
    {
        // récupération de la connexion à la BDD => objet PDO
        $pdo = Database::getPDO();

        // requête SQL
        $sql = '
        SELECT * FROM app_user';

        // on utilise query() pour récupérer les données simplement
        $pdoStatement = $pdo->query($sql);

        // on récupère le résultat sous la forme d'un array d'objets de la classe AppUser
        $result = $pdoStatement->fetchAll(\PDO::FETCH_CLASS, 'App\Models\AppUser');
        
        // on renvoie le résultat
        return $result;
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
     * Méthode permettant la mise à jour du model en base
     */
    public function update()
    {
        // pour l'instant, la méthode ne fait rien, on l'implémente juste pour respecter les méthodes abstraites de CoreModel
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

     /**
     * Méthode permettant la création du model en base
     */
    public function insert()
    {
        // récupération de la connexion à la BDD => objet PDO
        $pdo = Database::getPDO();

        // préparer la requête
        $sql = "
        INSERT INTO `app_user` (
            `email`,
            `password`,
            `firstname`,
            `lastname`, 
            `role`,
            `status`
        ) 
        VALUES (
            :email,
            :password,
            :firstname,
            :lastname,
            :role,
            :status
        )";


        $pdoStatement = $pdo->prepare($sql);

        // exécuter la requête
        $success = $pdoStatement->execute([
            ':email' => $this->email,
            ':password' => $this->password,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':role' => $this->role,
            ':status' => $this->status
        ]);

        // mettre à jour l'id du model
        if ($success) {
            $this->id = $pdo->lastInsertId();
        }

        // ne pas oublier de retourner le succes de l'opération
        return $success;
    }
}