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
    private string $client_nom; // nom du client
    private string $client_email; // email du client


    
    public function __construct(int $id_commandes = 0, int $id_clients = 0, string $date_commande = '', string $statut = '', string $client_nom = '', string $client_email = '', array $produits = []){
        $this->id_commandes = $id_commandes;
        $this->id_clients = $id_clients;
        $this->date_commande = $date_commande;
        $this->statut = $statut;
        $this->client_nom = $client_nom;
        $this->client_email = $client_email;
        $this->produits = $produits;
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
    public function JsonSerialize() {
        return [
            "id_commandes" => $this->id_commandes,
            "id_clients" => $this->id_clients,
            "client_name" => $this->client_nom,
            "client_email" => $this->client_email,
            "order_date" => $this->date_commande,
            "status" => $this->statut,
            "products" => $this->produits
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
    public function getIdClient(): int
    {
        return $this->id_clients;
    }

    /**
     * Set the value of id_clients
     *
     * @return  self
     */ 
    public function setIdClient(int $id_clients): self
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

    /**
     * Get the value of client_nom
     */ 
    public function getClientName(): string
    {
        return $this->client_nom;
    }

    /**
     * Set the value of client_nom
     *
     * @return  self
     */ 
    public function setClientName(string $client_nom): self
    {
        $this->client_nom = $client_nom;
        return $this;
    }

    /**
     * Get the value of client_email
     */ 
    public function getClientEmail(): string
    {
        return $this->client_email;
    }

    /**
     * Set the value of client_email
     *
     * @return  self
     */ 
    public function setClientEmail(string $client_email): self
    {
        $this->client_email = $client_email;
        return $this;
    }

    /**
     * Add a product to the order
     *
     * @param int $id_produits
     * @param int $quantity
     * @param float $price
     * @param int $id_options
     * @return self
     */
    public function addProduct(int $id_produits, int $quantity, float $price, int $id_options): self
    {
        $this->produits[] = [
            'id_produits' => $id_produits,
            'quantity' => $quantity,
            'price' => $price,
            'id_options' => $id_options
        ];
        return $this;
    }

}