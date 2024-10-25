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
class CommandeRepository extends EntityRepository
{

    public function __construct()
    {
        // appel au constructeur de la classe mère (va ouvrir la connexion à la bdd)
        parent::__construct();
    }

    // Trouver toutes les commandes se l'utilisateur qui fait la requête

    public function findByUser()
    {
        $idClients = $_SESSION['client']->getId();

        $requete = $this->cnx->prepare("select * from Commandes where id_clients=:value");
        $requete->bindParam(':value', $idClients);
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach ($answer as $obj) {
            $p = new Commande($obj->id_commandes);
            $p->setIdClient($obj->id_clients);
            $p->setDateCommande($obj->date_commande);
            $p->setStatut($obj->statut);

            array_push($res, $p);
        }

        foreach ($res as $commande) {
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
            foreach ($answerProduits as $obj) {
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

    public function find($id_commandes): ?Commande
    {
        $requete = $this->cnx->prepare("SELECT * FROM Commandes WHERE id_commandes=:value");
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

        // Retrieve client information
        $requeteClient = $this->cnx->prepare("SELECT nom, email FROM Clients WHERE id_clients=:value");
        $requeteClient->bindParam(':value', $obj->id_clients);
        $requeteClient->execute();
        $client = $requeteClient->fetch(PDO::FETCH_OBJ);

        if ($client) {
            $commande->setClientName($client->nom);
            $commande->setClientEmail($client->email);
        }

        $requeteProduits = $this->cnx->prepare("
            SELECT cp.*, p.nom, p.revendeur, po.image, o.nom_court 
            FROM Commandes_Produits cp
            JOIN Produits p ON cp.id_produits = p.id_produits
            JOIN Produits_Options po ON cp.id_produits = po.id_produits AND cp.id_options = po.id_options
            JOIN Options o ON cp.id_options = o.id_options
            WHERE cp.id_commandes = :value
        ");
        $requeteProduits->bindParam(':value', $id_commandes);
        $requeteProduits->execute();
        $answerProduits = $requeteProduits->fetchAll(PDO::FETCH_OBJ);

        $produits = [];
        foreach ($answerProduits as $obj) {
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

        return $commande;
    }



    // Trouver toutes les commandes

    public function findAll(): array
    {
        $requete = $this->cnx->prepare("SELECT * FROM Commandes ORDER BY date_commande DESC");
        $requete->execute();
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);

        $res = [];
        foreach ($answer as $obj) {
            $p = new Commande($obj->id_commandes);
            $p->setIdClient($obj->id_clients);
            $p->setDateCommande($obj->date_commande);
            $p->setStatut($obj->statut);

            // Retrieve client information
            $requeteClient = $this->cnx->prepare("SELECT nom, email FROM Clients WHERE id_clients=:value");
            $requeteClient->bindParam(':value', $obj->id_clients);
            $requeteClient->execute();
            $client = $requeteClient->fetch(PDO::FETCH_OBJ);

            if ($client) {
                $p->setClientName($client->nom);
                $p->setClientEmail($client->email);
            }

            array_push($res, $p);
        }

        foreach ($res as $commande) {
            $requeteProduits = $this->cnx->prepare("
                SELECT cp.*, p.nom, p.revendeur, po.image, po.stock, o.nom_court 
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
            foreach ($answerProduits as $obj) {
                $produit = [
                    'id_produits' => $obj->id_produits,
                    'quantity' => $obj->quantite,
                    'price' => $obj->prix,
                    'id_options' => $obj->id_options,
                    'stock' => $obj->stock,
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

    // Sauvegarder une commande

    public function save($commande)
    {
        // On commence une transaction si ce n'est pas déjà fait
        if (!$this->cnx->inTransaction()) {
            $this->cnx->beginTransaction();
        }


        try {
            // On enregistre la commande avec le statut "en_cours" et la date et l'heure actuelles
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

            // On ajoute chaque produits à la commande un à un
            foreach ($produits as $produit) {
                $requeteProduit = $this->cnx->prepare("insert into Commandes_Produits (id_produits, id_commandes, quantite, prix, id_options) values (:id_produits, :id_commandes, :quantite, :prix, :id_options)");
                $requeteProduit->bindParam(':id_produits', $produit['id_produits']);
                $requeteProduit->bindParam(':id_commandes', $idCommandes);
                $requeteProduit->bindParam(':quantite', $produit['quantity']);
                $requeteProduit->bindParam(':prix', $produit['price']);
                $requeteProduit->bindParam(':id_options', $produit['id_options']);
                $requeteProduit->execute();

                // On met à jour le stock du produit
                $requeteUpdateStock = $this->cnx->prepare("UPDATE Produits_Options SET stock = stock - :quantite WHERE id_produits = :id_produits AND id_options = :id_options");
                $requeteUpdateStock->bindParam(':quantite', $produit['quantity']);
                $requeteUpdateStock->bindParam(':id_produits', $produit['id_produits']);
                $requeteUpdateStock->bindParam(':id_options', $produit['id_options']);
                $requeteUpdateStock->execute();
            }


            // On commit la transaction

            $this->cnx->commit();

            
            return $idCommandes;
        } catch (Exception $e) {
            if ($this->cnx->inTransaction()) {
                $this->cnx->rollBack();
            }
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        // Not implemented ! TODO when needed !
        return false;
    }

    public function update($commande)
    {
        // On récupère le statut précédent de la commande pour
        $previousStatus = $this->find($commande->getId())->getStatut();

        // Sert à mettre à jour une commande, sert notamment pour le statut

        $requete = $this->cnx->prepare("UPDATE Commandes SET statut = :statut WHERE id_commandes = :id_commandes");
        $statut = $commande->getStatut();
        $idCommandes = $commande->getId();

        $requete->bindParam(':statut', $statut);
        $requete->bindParam(':id_commandes', $idCommandes);


        // Si le statut passe à "annulee", on remet le stock des produits commandés
        if ($statut == "annulee") {
            $produits = $commande->getProduits();
            foreach ($produits as $produit) {
                $requeteUpdateStock = $this->cnx->prepare("UPDATE Produits_Options SET stock = stock + :quantite WHERE id_produits = :id_produits AND id_options = :id_options");
                $requeteUpdateStock->bindParam(':quantite', $produit['quantity']);
                $requeteUpdateStock->bindParam(':id_produits', $produit['id_produits']);
                $requeteUpdateStock->bindParam(':id_options', $produit['id_options']);
                $requeteUpdateStock->execute();
            }
        } else if ($previousStatus == "annulee") {
            // Si le statut passe de "annulee" à un autre statut, on retire à nouveau les produits du stock
            $produits = $commande->getProduits();
            foreach ($produits as $produit) {
                $requeteUpdateStock = $this->cnx->prepare("UPDATE Produits_Options SET stock = stock - :quantite WHERE id_produits = :id_produits AND id_options = :id_options");
                $requeteUpdateStock->bindParam(':quantite', $produit['quantity']);
                $requeteUpdateStock->bindParam(':id_produits', $produit['id_produits']);
                $requeteUpdateStock->bindParam(':id_options', $produit['id_options']);
                $requeteUpdateStock->execute();
            }
        }

        $answer = $requete->execute(); // an update query returns true or false. $answer is a boolean.

        return $answer;
    }

    // Mettre à jour le stock d'un produit
    public function updateStock($id_produits, $id_options, $quantity)
    {
        $requete = $this->cnx->prepare("UPDATE Produits_Options SET stock = stock - :quantity WHERE id_produits = :id_produits AND id_options = :id_options");
        $requete->bindParam(':quantity', $quantity);
        $requete->bindParam(':id_produits', $id_produits);
        $requete->bindParam(':id_options', $id_options);
        $answer = $requete->execute(); // an update query returns true or false. $answer is a boolean.

        return $answer;
    }

    // Mettre à jour les quantités d'un produit dans une commande et le statut de la commande
    public function updateProduct($idProduits, $idOptions, $quantity) {
        $requete = $this->cnx->prepare("UPDATE Commandes_Produits SET quantite = :quantite WHERE id_produits = :id_produits AND id_options = :id_options");
        $requete->bindParam(':quantite', $quantity);
        $requete->bindParam(':id_produits', $idProduits);
        $requete->bindParam(':id_options', $idOptions);
        $answer = $requete->execute(); // an update query returns true or false. $answer is a boolean.

        return $answer;
    }

    // Dupliquer une commande
    public function duplicate($commande)
    {
        // On récupère les produits de la commande cible
        $produits = $commande->getProduits();

        // On vérifie les stocks pour chaque produit
        foreach ($produits as $produit) {
            $requeteStock = $this->cnx->prepare("SELECT stock FROM Produits_Options WHERE id_produits = :id_produits AND id_options = :id_options");
            $requeteStock->bindParam(':id_produits', $produit['id_produits']);
            $requeteStock->bindParam(':id_options', $produit['id_options']);
            $requeteStock->execute();
            $stock = $requeteStock->fetch(PDO::FETCH_OBJ)->stock;

            if ($stock < $produit['quantity']) {
                throw new Exception("Stock insuffisant pour le produit " . $produit['id_produits']);
            }
        }

        // On commence une transaction si ce n'est pas déjà fait
        if (!$this->cnx->inTransaction()) {
            $this->cnx->beginTransaction();
        }

        try {
            // On crée une nouvelle commande pour l'utilisateur actuel
            $newCommande = new Commande(0); // 0 est une valeur symbolique temporaire

            // On vérifie que l'utilisateur est connecté
            if (!isset($_SESSION['client'])) {
                // $newCommande->setIdClient(14); // pour les tests
                throw new Exception("Client non connecté");

            }
            $newCommande->setIdClient($_SESSION['client']->getId());
            $newCommande->setStatut("en_cours");
            $newCommande->setDateCommande(date('Y-m-d H:i:s'));

            // On enregistre la nouvelle commande
            $idNewCommande = $this->save($newCommande);


            // On ajoute les produits à la nouvelle commande
            foreach ($produits as $produit) {
                
                $requeteProduit = $this->cnx->prepare("INSERT INTO Commandes_Produits (id_produits, id_commandes, quantite, prix, id_options) VALUES (:id_produits, :id_commandes, :quantite, :prix, :id_options)");
                $requeteProduit->bindParam(':id_produits', $produit['id_produits']);
                $requeteProduit->bindParam(':id_commandes', $idNewCommande);
                $requeteProduit->bindParam(':quantite', $produit['quantity']);
                $requeteProduit->bindParam(':prix', $produit['price']);
                $requeteProduit->bindParam(':id_options', $produit['id_options']);
                $requeteProduit->execute();

                // On met à jour le stock du produit
                $requeteUpdateStock = $this->cnx->prepare("UPDATE Produits_Options SET stock = stock - :quantite WHERE id_produits = :id_produits AND id_options = :id_options");
                $requeteUpdateStock->bindParam(':quantite', $produit['quantity']);
                $requeteUpdateStock->bindParam(':id_produits', $produit['id_produits']);
                $requeteUpdateStock->bindParam(':id_options', $produit['id_options']);
                $requeteUpdateStock->execute();
            }


            // On retourne la nouvelle commande
            return $this->find($idNewCommande);
        } catch (Exception $e) {
            // On rollback la transaction en cas d'erreur si elle a été commencée
            if ($this->cnx->inTransaction()) {
                $this->cnx->rollBack();
            }
            throw $e;
        }
    }
}
