<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Client.php");


/**
 *  Classe ClientRepository
 * 
 *  Cette classe représente le "stock" de Client.
 *  Toutes les opérations sur les Client doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class ClientRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id): ?Client{
        $requete = $this->cnx->prepare("select * from Produits where id_clients=:value");
        $requete->bindParam(':value', $id);
        $requete->execute();
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer == false) return null;
        
        $p = new Client($answer->id_produits);
        $p->setName($answer->nom);
        $p->setEmail($answer->email);
        $p->setPassword($answer->password);


        return $p;
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("select * from Clients");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Client($obj->id_clients);
            $p->setName($obj->nom);
            $p->setEmail($obj->email);
            $p->setPassword($obj->mot_de_passe);

            array_push($res, $p);
        }
       
        return $res;
    }


    public function save($client){
        $requete = $this->cnx->prepare("insert into Clients (nom, email, password) values (:name, :email, :password)");
        $name = $client->getName();
        $email = $client->getEmail();
        $password = $client->getPassword();
        
        $requete->bindParam(':name', $name);
        $requete->bindParam(':email', $email);
        $requete->bindParam(':password', $password);
        $answer = $requete->execute(); // an insert query returns true or false. $answer is a boolean.

        if ($answer){
            $id = $this->cnx->lastInsertId(); // retrieve the id of the last insert query
            $client->setId($id); // set the client id to its real value.
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