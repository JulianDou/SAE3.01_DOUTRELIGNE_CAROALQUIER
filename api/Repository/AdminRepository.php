<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Admin.php");


/**
 *  Classe AdminRepository
 * 
 *  Cette classe représente le "stock" de Admin.
 *  Toutes les opérations sur les Admin doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class AdminRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }


    public function find($id): ?Admin{
        $requete = $this->cnx->prepare("select * from Admins where id_admins=:value");
        $requete->bindParam(':value', $id);
        $requete->execute();
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer == false) return null;
        
        $p = new Admin($answer->id_produits);
        $p->setName($answer->nom);
        $p->setEmail($answer->email);
        $p->setPassword($answer->password);

        
        return $p;
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("select * from Admins");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Admin($obj->id_admins);
            $p->setName($obj->nom);
            $p->setEmail($obj->email);
            $p->setPassword($obj->mot_de_passe);

            array_push($res, $p);
        }
       
        return $res;
    }

    // Trouver le client avec son mail 
    public function findByName($name) {
        $requete = $this->cnx->prepare("select * from Admins where nom=:value");
        $requete->bindParam(':value', $name);
        $requete->execute();
        $answer = $requete->fetch(PDO::FETCH_OBJ);

        if ($answer == false) return null;

        $p = new Admin($answer->id_admins);
        $p->setName($answer->nom);
        $p->setEmail($answer->email);
        $p->setPassword($answer->mot_de_passe);

        return $p;
    } 


    public function save($admin){
        $requete = $this->cnx->prepare("insert into Admins (nom, email, mot_de_passe) values (:name, :email, :mot_de_passe)");
        $name = $admin->getName();
        $email = $admin->getEmail();
        $mot_de_passe = $admin->getPassword();
        
        $requete->bindParam(':name', $name);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':mot_de_passe', $mot_de_passe);
        $answer = $requete->execute(); // an insert query returns true or false. $answer is a boolean.

        if ($answer){
            $id = $this->cnx->lastInsertId(); // retrieve the id of the last insert query
            $admin->setId($id); // set the client id to its real value.
            return true;
        }
          
        return false;
    }

    public function delete($id){
        // Not implemented ! TODO when needed !
        return false;
    }

    public function update($product){
        // Not implemented ! TODO when needed !
        return false;
    }

   
    
}