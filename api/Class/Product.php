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
class Product implements JsonSerializable {
    private int $id_produits; // id du produit
    private string $nom; // nom du produit
    private int $id_categories; // id de la catégorie du produit
    private float $prix; // prix du produit
    private string $description; // description du produit
    private string $image; // image du produit
    private string $revendeur; // revendeur du produit

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
    public function JsonSerialize(): mixed {
        return [
            "id" => $this->id_produits,
            "name" => $this->nom,
            "category" => $this->id_categories,
            "price" => $this->prix ?? null,
            "description" => $this->description ?? null,
            "image" => $this->image ?? null,
            "revendeur" => $this->revendeur ?? null
        ];
    }

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id_produits;
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
     * Get the value of idcategory
     */ 
    public function getIdcategory()
    {
        return $this->id_categories;
    }

    /**
     * Set the value of idcategory là
     *
     * @return  self
     */ 
    public function setIdcategory(int $idcategory): self
    {
        $this->id_categories = $idcategory;
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
}