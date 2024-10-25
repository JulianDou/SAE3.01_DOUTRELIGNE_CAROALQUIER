<?php
/**
 *  Class Product
 * 
 *  Représente un produit avec uniquement 3 propriétés (id, name, category)
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Product doivent être converti en JSON. Voire la méthode pour plus de détails.
 */
class Option implements JsonSerializable {
    private int $id_produits; // id du produit
    private string $nom; // nom du produit
    private float $prix; // prix du produit
    private string $description; // description du produit
    private string $image; // image du produit
    private string $revendeur; // revendeur du produit
    private int $id_options; // id de l'option du produit
    private string $nom_court; // nom court de l'option (dans l'option de base)
    private int $stock; // stock de l'option


    public function __construct(int $id_produits){
        $this->id_produits = $id_produits;
    }

     /**
     *  Define how to convert/serialize a Product to a JSON format
     *  This method will be automatically invoked by json_encode when apply to a Product
     * 
     *  En français : On sait qu'on aura besoin de convertir des Product en JSON pour les
     *  envoyer au client. La fonction json_encode sait comment convertir en JSON des données
     *  de type élémentaire. A savoir : des chaînes de caractères, des nombres, des booléens
     *  des tableaux ou des objets standards (stdClass). 
     *  Mais json_encode ne saura pas convertir un objet de type Product dont les propriétés sont
     *  privées de surcroit. Sauf si on définit la méthode JsonSerialize qui doit retourner une
     *  représentation d'un Product dans un format que json_encode sait convertir (ici un tableau associatif)
     * 
     *  Le fait que Product "implémente" l'interface JsonSerializable oblige à définir la méthode
     *  JsonSerialize et permet à json_encode de savoir comment convertir un Product en JSON.
     * 
     *  Parenthèse sur les "interfaces" : Une interface est une classe (abstraite en générale) qui
     *  regroupe un ensemble de méthodes. On dit que "une classe implémente une interface" au lieu de dire 
     *  que "une classe hérite d'une autre" uniquement parce qu'il n'y a pas de propriétés dans une "classe interface".
     * 
     *  Voir aussi : https://www.php.net/manual/en/class.jsonserializable.php
     *  
     */


//      Format visé pour la récupération  :



public function JsonSerialize(): mixed {
    $json = [
        "id" => $this->id_produits,
        "id_options" => $this->id_options ?? null,
        "stock" => $this->stock ?? null,
        "name" => $this->nom ?? null,
        "short_name" => $this->nom_court ?? null,
        "category" => $this->id_categories ?? null,
        "price" => $this->prix ?? null,
        "description" => $this->description ?? null,
        "image" => $this->image ?? null,
        "retailer" => $this->revendeur ?? null
    ];

    // Remove fields with null values
    return array_filter($json, function($value) {
        return !is_null($value);
    });
}

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id_produits;
    }

        /**
     * Set the value of id_options
     *
     * @return  self
     */

     public function setIdOptions(int $id_options): self
     {
         $this->id_options = $id_options;
         return $this;  
     }
    /**
     * get the value of id for option
     */
    public function getIdOptions(): int
    {
        return $this->id_options;
    }

    /**
     * Get the value of prix
     */
    public function getPrice(): float
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     *
     * @return  self
     */ 
    public function setPrice(float $prix):  self
    {
        $this->prix = $prix;
        return $this;
    }


    /**
     * Get the value of description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Get the value of revendeur
     */
    public function getRevendeur(): string
    {
        return $this->revendeur;
    }

    /**
     * Set the value of revendeur
     *
     * @return  self
     */
    public function setRevendeur(string $revendeur): self
    {
        $this->revendeur = $revendeur;
        return $this;
    }



    

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->nom;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name): self
    {
        $this->nom = $name;
        return $this;
    }



    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id): self
    {
        $this->id_produits = $id;
        return $this;
    }
    
    /**
     * Set the value of nom court
     *
     * @return  self
     */ 
    public function setNomCourt(string $nom_court): self
    {
        $this->nom_court = $nom_court;
        return $this;
    }

    /**
     * Get the value of nom court
     *
     * @return  self
     */
    public function getNomCourt(): string
    {
        return $this->nom_court;
    }

    /**
     * Set the value of stock
     *
     * @return  self
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    /**
     * Get the value of stock
     *
     * @return  self
     */
    public function getStock(): int
    {
        return $this->stock;
    }



    
}