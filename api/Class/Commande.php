<?php
/**
 *  Class Commande
 * 
 *  Représente un produit avec uniquement 3 propriétés (id, name, category)
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Commande doivent être converti en JSON. Voire la méthode pour plus de détails.
 */
class Commande implements JsonSerializable {
    private int $id_commandes; // id de la commande
    private int $id_clients;  // id du client
    private string $date_commande; // date de la commande
    private string $statut; // statut de la commande
    private array $produits; // liste des produits


    

    public function __construct(int $id_commandes){
        $this->id_commandes = $id_commandes;

        
    }

     /**
     *  Define how to convert/serialize a Commande to a JSON format
     *  This method will be automatically invoked by json_encode when apply to a Commande
     * 
     *  En français : On sait qu'on aura besoin de convertir des Commande en JSON pour les
     *  envoyer au client. La fonction json_encode sait comment convertir en JSON des données
     *  de type élémentaire. A savoir : des chaînes de caractères, des nombres, des booléens
     *  des tableaux ou des objets standards (stdClass). 
     *  Mais json_encode ne saura pas convertir un objet de type Commande dont les propriétés sont
     *  privées de surcroit. Sauf si on définit la méthode JsonSerialize qui doit retourner une
     *  représentation d'un Commande dans un format que json_encode sait convertir (ici un tableau associatif)
     * 
     *  Le fait que Commande "implémente" l'interface JsonSerializable oblige à définir la méthode
     *  JsonSerialize et permet à json_encode de savoir comment convertir un Commande en JSON.
     * 
     *  Parenthèse sur les "interfaces" : Une interface est une classe (abstraite en générale) qui
     *  regroupe un ensemble de méthodes. On dit que "une classe implémente une interface" au lieu de dire 
     *  que "une classe hérite d'une autre" uniquement parce qu'il n'y a pas de propriétés dans une "classe interface".
     * 
     *  Voir aussi : https://www.php.net/manual/en/class.jsonserializable.php
     *  
     */
    public function JsonSerialize(): mixed {
        return [
            "id_commandes" => $this->id_commandes,
            "id_clients" => $this->id_clients,
            "date_commande" => $this->date_commande,
            "statut" => $this->statut,
            "produits" => $this->produits
        ];
    }

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id_commandes;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): self
    {
        $this->id_commandes = $id;
        return $this;
    }

    /**
     * Get the value of id_clients
     */ 
    public function getIdClients(): int
    {
        return $this->id_clients;
    }

    /**
     * Set the value of id_clients
     *
     * @return  self
     */ 
    public function setIdClients(int $id_clients): self
    {
        $this->id_clients = $id_clients;
        return $this;
    }

    /**
     * Get the value of date_commande
     */ 
    public function getDateCommande(): string
    {
        return $this->date_commande;
    }

    /**
     * Set the value of date_commande
     *
     * @return  self
     */ 
    public function setDateCommande(string $date_commande): self
    {
        $this->date_commande = $date_commande;
        return $this;
    }

    /**
     * Get the value of statut
     */ 
    public function getStatut(): string
    {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @return  self
     */ 
    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }


    /**
     * Get the value of produits
     */ 
    public function getProduits(): array
    {
        return $this->produits;
    }

    /**
     * Set the value of produits
     *
     * @return  self
     */ 
    public function setProduits(array $produits): self
    {
        $this->produits = $produits;
        return $this;
    }
}