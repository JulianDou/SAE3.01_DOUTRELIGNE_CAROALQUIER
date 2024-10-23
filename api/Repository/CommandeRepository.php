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

    // Trouver toutes les commandes se l'utilisateur qui fait la requête

    public function findByUser() {
        $idClients = $_SESSION['client']->getId();

        $requete = $this->cnx->prepare("select * from Commandes where id_clients=:value");
        $requete->bindParam(':value', $idClients);
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach($answer as $obj){
            $p = new Commande($obj->id_commandes);
            $p->setIdClient($obj->id_clients);
            $p->setDateCommande($obj->date_commande);
            $p->setStatut($obj->statut);

            array_push($res, $p);
        }

        foreach($res as $commande){
            $requeteProduits = $this->cnx->prepare("
                SELECT cp.*, p.nom, p.revendeur, po.image, o.nom_court 
                FROM Commandes_Produits cp
                JOIN Produits p ON cp.id_produits = p.id_produits
                JOIN Produits_Options po ON cp.id_produits = po.id_produits AND cp.id_options = po.id_options
                JOIN Options o ON cp.id_options = o.id_options
                WHERE cp.id_commandes = :value
            ");
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
                    'id_options' => $obj->id_options,
                    'name' => $obj->nom,
                    'retailer' => $obj->revendeur,
                    'image' => $obj->image,
                    'short_name' => $obj->nom_court
                ];
                array_push($produits, $produit);
            }
            $commande->setProduits($produits);
        }
       
        return $res;
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
        $commande->setIdClient($obj->id_clients);
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
            $p->setIdClient($obj->id_clients);
            $p->setDateCommande($obj->date_commande);
            $p->setStatut($obj->statut);

            // Retrieve client information
            $requeteClient = $this->cnx->prepare("select nom, email from Clients where id_clients=:value");
            $requeteClient->bindParam(':value', $obj->id_clients);
            $requeteClient->execute();
            $client = $requeteClient->fetch(PDO::FETCH_OBJ);

            if ($client) {
                $p->setClientName($client->nom);
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
        $this->cnx->beginTransaction();
        
        try {
            $requete = $this->cnx->prepare("insert into Commandes (statut, date_commande, id_clients) values (:statut, :date_commande, :id_clients)");
            $statut = "en_cours";
            $dateCommande = date('Y-m-d H:i:s');
            $idClients = $commande->getIdClient();
            
            $requete->bindParam(':statut', $statut);
            $requete->bindParam(':date_commande', $dateCommande);
            $requete->bindParam(':id_clients', $idClients);
            $requete->execute();
            
            $produits = $commande->getProduits();
            $idCommandes = $this->cnx->lastInsertId();

            foreach ($produits as $produit) {
            $requeteProduit = $this->cnx->prepare("insert into Commandes_Produits (id_produits, id_commandes, quantite, prix, id_options) values (:id_produits, :id_commandes, :quantite, :prix, :id_options)");
            $requeteProduit->bindParam(':id_produits', $produit['id_produits']);
            $requeteProduit->bindParam(':id_commandes', $idCommandes);
            $requeteProduit->bindParam(':quantite', $produit['quantity']);
            $requeteProduit->bindParam(':prix', $produit['price']);
            $requeteProduit->bindParam(':id_options', $produit['id_options']);
            $requeteProduit->execute();
            }

            $this->cnx->commit();
            return true;
        } catch (Exception $e) {
            $this->cnx->rollBack();
            echo $e->getMessage();
            return false;
        }
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