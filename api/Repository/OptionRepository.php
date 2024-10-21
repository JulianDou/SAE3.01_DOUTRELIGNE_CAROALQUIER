<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Option.php");


/**
 *  Classe OptionRepository
 * 
 *  Cette classe représente le "stock" de Option.
 *  Toutes les opérations sur les Option doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class OptionRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    public function find($id_produits): array {
        $requete = $this->cnx->prepare("select * from Produits where id_produits=:value");
        $requete->bindParam(':value', $id_produits);
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Option($obj->id_produits);
            $p->setName($obj->nom);
            $p->setDescription($obj->description);
            $p->setRevendeur($obj->revendeur);

            // Fetch all options for the product
            $requeteOptions = $this->cnx->prepare("
                select Produits_Options.*, Options.nom_court 
                from Produits_Options
                inner join Options on Produits_Options.id_options = Options.id_options
                where Produits_Options.id_produits=:value
            ");
            $requeteOptions->bindParam(':value', $obj->id_produits);
            $requeteOptions->execute();
            $options = $requeteOptions->fetchAll(PDO::FETCH_OBJ);

            foreach ($options as $option) {
                $optionProduct = clone $p;
                $optionProduct->setPrice($option->prix); // Assuming you have a setPrice method in Option class
                $optionProduct->setImage($option->image); // Assuming you have a setImage method in Option class
                $optionProduct->setNomCourt($option->nom_court); // Assuming you have a setNomCourt method in Option class
                $optionProduct->setIdOptions($option->id_options); // Assuming you have a setIdOptions method in Option class

                array_push($res, $optionProduct);
            }
        }
       
        return $res;
    }


    public function findAll(): array {
        $requete = $this->cnx->prepare("
            select Produits.*, Produits_Options.prix, Produits_Options.image, Options.nom_court, Options.id_options 
            from Produits
            left join Produits_Options on Produits.id_produits = Produits_Options.id_produits
            left join Options on Produits_Options.id_options = Options.id_options
        ");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Option($obj->id_produits);
            $p->setName($obj->nom); // Ensure this is the correct field for the product name
            $p->setDescription($obj->description);
            $p->setRevendeur($obj->revendeur);

            if ($obj->prix !== null) {
                $p->setPrice($obj->prix); // Assuming you have a setPrice method in Option class
                $p->setImage($obj->image); // Assuming you have a setImage method in Option class
                $p->setNomCourt($obj->nom_court); // Assuming you have a setNomCourt method in Option class
                $p->setIdOptions($obj->id_options); // Assuming you have a setIdOptions method in Option class
            }

            array_push($res, $p);
        }
       
        return $res;
    }

    // public function findAllByCategory($id): array {
    //     $requete = $this->cnx->prepare("select * from Produits where id_categories=:value");
    //     $requete->bindParam(':value', $id);
    //     $requete->execute();
    //     $answer = $requete->fetchAll(PDO::FETCH_OBJ);

    //     $res = [];
    //     foreach($answer as $obj){
    //         $p = new Option($obj->id_produits);
    //         $p->setName($obj->nom);
    //         $p->setDescription($obj->description);
    //         $p->setRevendeur($obj->revendeur);

    //         // Fetch options for the product
    //         $requeteOptions = $this->cnx->prepare("select * from Produits_Options where id_produits=:value limit 1");
    //         $requeteOptions->bindParam(':value', $obj->id_produits);
    //         $requeteOptions->execute();
    //         $option = $requeteOptions->fetch(PDO::FETCH_OBJ);

    //         if ($option) {
    //             $p->setPrice($option->prix); // Assuming you have a setPrice method in Option class
    //             $p->setImage($option->image); // Assuming you have a setImage method in Option class
    //         }

    //         array_push($res, $p);
    //     }
       
    //     return $res;
    // }

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