<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Commande.php");


/**
 *  Classe CommandeRepository
 * 
 *  Cette classe représente le "stock" de Commande.
 *  Toutes les opérations sur les Commande doivent se faire via cette classe 
 *  qui tient "synchro" la bdd en conséquence.
 * 
 *  La classe hérite de EntityRepository ce qui oblige à définir les méthodes  (find, findAll ... )
 *  Mais il est tout à fait possible d'ajouter des méthodes supplémentaires si
 *  c'est utile !
 *  
 */
class CommandeRepository extends EntityRepository {

    public function __construct(){
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    // Trouver une commande par son id

    public function find($id_commandes): ?Commande {
        $requete = $this->cnx->prepare("select * from Commandes where id_commandes=:value");
        $requete->bindParam(':value', $id_commandes);
        $requete->execute();
        $obj = $requete->fetch(PDO::FETCH_OBJ);

        if (!$obj) {
            return null;
        }

        $commande = new Commande($obj->id_commandes);
        $commande->setIdClients($obj->id_clients);
        $commande->setDateCommande($obj->date_commande);
        $commande->setStatut($obj->statut);

        $requeteProduits = $this->cnx->prepare("select * from Commandes_Produits where id_commandes=:value");
        $idCommande = $commande->getId();
        $requeteProduits->bindParam(':value', $idCommande);
        $requeteProduits->execute();
        $answerProduits = $requeteProduits->fetchAll(PDO::FETCH_OBJ);

        $produits = [];
        foreach($answerProduits as $obj){
            $produit = [
                'id_produits' => $obj->id_produits,
                'quantity' => $obj->quantite,
                'price' => $obj->prix
            ];
            array_push($produits, $produit);
        }
        $commande->setProduits($produits);

        return $commande;
    }

    // Trouver toutes les commandes

    public function findAll(): array {
        $requete = $this->cnx->prepare("select * from Commandes");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Commande($obj->id_commandes);
            $p->setIdClients($obj->id_clients);
            $p->setDateCommande($obj->date_commande);
            $p->setStatut($obj->statut);

            // Retrieve client information
            $requeteClient = $this->cnx->prepare("select nom, email from Clients where id_clients=:value");
            $requeteClient->bindParam(':value', $obj->id_clients);
            $requeteClient->execute();
            $client = $requeteClient->fetch(PDO::FETCH_OBJ);

            if ($client) {
                $p->setClientNom($client->nom);
                $p->setClientEmail($client->email);
            }

            array_push($res, $p);
        }

        foreach($res as $commande){
            $requeteProduits = $this->cnx->prepare("select * from Commandes_Produits where id_commandes=:value");
            $idCommande = $commande->getId();
            $requeteProduits->bindParam(':value', $idCommande);
            $requeteProduits->execute();
            $answerProduits = $requeteProduits->fetchAll(PDO::FETCH_OBJ);

            $produits = [];
            foreach($answerProduits as $obj){
                $produit = [
                    'id_produits' => $obj->id_produits,
                    'quantity' => $obj->quantite,
                    'price' => $obj->prix,
                    'id_options' => $obj->id_options
                ];
                array_push($produits, $produit);
            }
            $commande->setProduits($produits);
        }
       
        return $res;
    }

    // Sauvegarder une commande

    public function save($commande){
        $requete = $this->cnx->prepare("insert into Commandes (statut, date_commande, id_clients) values (:statut, :date_commande, :id_clients)");
        $statut = $commande->getStatut();
        $dateCommande = $commande->getDateCommande();
        $idClients = $commande->getIdClients();
        
        $requete->bindParam(':statut', $statut);
        $requete->bindParam(':date_commande', $dateCommande);
        $requete->bindParam(':id_clients', $idClients);
        $answer = $requete->execute(); // an insert query returns true or false. $answer is a boolean.

        if ($answer){
            $id = $this->cnx->lastInsertId(); // retrieve the id of the last insert query
            $commande->setIdCommandes($id); // set the commande id to its real value.
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