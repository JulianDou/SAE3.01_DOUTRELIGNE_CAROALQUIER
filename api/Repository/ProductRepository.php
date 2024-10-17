<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Product.php");


/**
 *  Classe ProductRepository
 * 
 *  Cette classe représente le "stock" de Product.
 *  Toutes les opérations sur les Product doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class ProductRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id): ?Product{
        /*
            La façon de faire une requête SQL ci-dessous est "meilleur" que celle vue
            au précédent semestre (cnx->query). Notamment l'utilisation de bindParam
            permet de vérifier que la valeur transmise est "safe" et de se prémunir
            d'injection SQL.
        */
        $requete = $this->cnx->prepare("select * from Produits where id_produits=:value"); // prepare la requête SQL
        $requete->bindParam(':value', $id); // fait le lien entre le "tag" :value et la valeur de $id
        $requete->execute(); // execute la requête
        $answer = $requete->fetch(PDO::FETCH_OBJ);
        
        if ($answer==false) return null; // may be false if the sql request failed (wrong $id value for example)
        
        $p = new Product($answer->id_produits);
        $p->setName($answer->nom);
        $p->setIdcategory($answer->id_categories);
        $p->setPrice($answer->prix);
        $p->setDescription($answer->description);
        $p->setImage($answer->image);
        $p->setRevendeur($answer->revendeur);
        
        return $p;
    }

    public function findAll(): array {
        $requete = $this->cnx->prepare("select * from Produits");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Product($obj->id_produits);
            $p->setName($obj->nom);
            $p->setIdcategory($obj->id_categories);
            $p->setPrice($obj->prix);
            $p->setDescription($obj->description);
            $p->setImage($obj->image);
            $p->setRevendeur($obj->revendeur);
            array_push($res, $p);
        }
       
        return $res;
    }

    public function findAllByCategory($id): array {
        
        $requete = $this->cnx->prepare("select * from Options where id_categories=:value");
        $requete->bindParam(':value', $id); // fait le lien entre le "tag" :value et la valeur de $id
        $requete->execute(); // execute la requête
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        if ($answer) {
            foreach($answer as $obj){
                $p = new Product($obj->id_produits);
                $p->setName($obj->nom);
                $p->setIdcategory($obj->id_categories);
                $p->setPrice($obj->prix);
                $p->setDescription($obj->description);
                $p->setImage($obj->image);
                $p->setRevendeur($obj->revendeur);
                array_push($res, $p);
            }
        }
       
        return $res;
    }

    public function save($product){
        $requete = $this->cnx->prepare("insert into Produits (nom, id_categories) values (:name, :idcategory)");
        $name = $product->getName();
        
        $idcat = $product->getIdcategory();
        $requete->bindParam(':name', $name );
        $requete->bindParam(':idcategory', $idcat);
        $answer = $requete->execute(); // an insert query returns true or false. $answer is a boolean.

        if ($answer){
            $id = $this->cnx->lastInsertId(); // retrieve the id of the last insert query
            $product->setId($id); // set the product id to its real value.
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