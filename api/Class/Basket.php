<?php
/**
 *  Class Basket
 * 
 *  Représente un produit avec uniquement 3 propriétés (id, name, category)
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Basket doivent être converti en JSON. Voire la méthode pour plus de détails.
 */
class Basket implements JsonSerializable {
    private int $id_clients; // id du client


    public function __construct(int $id_clients){
        $this->id_clients = $id_clients;
        
    }

     /**
     *  Define how to convert/serialize a Basket to a JSON format
     *  This method will be automatically invoked by json_encode when apply to a Basket
     * 
     *  En français : On sait qu'on aura besoin de convertir des Basket en JSON pour les
     *  envoyer au client. La fonction json_encode sait comment convertir en JSON des données
     *  de type élémentaire. A savoir : des chaînes de caractères, des nombres, des booléens
     *  des tableaux ou des objets standards (stdClass). 
     *  Mais json_encode ne saura pas convertir un objet de type Basket dont les propriétés sont
     *  privées de surcroit. Sauf si on définit la méthode JsonSerialize qui doit retourner une
     *  représentation d'un Basket dans un format que json_encode sait convertir (ici un tableau associatif)
     * 
     *  Le fait que Basket "implémente" l'interface JsonSerializable oblige à définir la méthode
     *  JsonSerialize et permet à json_encode de savoir comment convertir un Basket en JSON.
     * 
     *  Parenthèse sur les "interfaces" : Une interface est une classe (abstraite en générale) qui
     *  regroupe un ensemble de méthodes. On dit que "une classe implémente une interface" au lieu de dire 
     *  que "une classe hérite d'une autre" uniquement parce qu'il n'y a pas de propriétés dans une "classe interface".
     * 
     *  Voir aussi : https://www.php.net/manual/en/class.jsonserializable.php
     *  
     */


//      Format visé pour la récupération  :

// {
//     "id_product":1
//     "options": [
//         {
//             "id_options: 3,
//             "name":"Manette Xbox",
//             "category":1,
//             "price":59.99,
//             "description":"Une superbe manette",
//             "image":"https:\/\/img-prod-cms-rt-microsoft-com.akamaized.net\/cms\/api\/am\/imageFileData\/RE4FlSK?ver=3eb6",
//             "revendeur":"Microsoft"
//         },
//         {
//             "id_options: 4,
//             "name":"Manette Xbox Bleu",
//             "category":1,
//             "price":69.99,
//             "description":"Une superbe manette",
//             "image":"https:\/\/img-prod-cms-rt-microsoft-com.akamaized.net\/cms\/api\/am\/imageFileData\/RE4FlSK?ver=3eb6",
//             "revendeur":"Microsoft"
//         }
//     ]
// }

public function JsonSerialize(): mixed {
    $json = [
        "id" => $this->id_clients
    ];

    return $json;
}

    /**
     * Get the value of id
     */ 
    public function getId(): int
    {
        return $this->id_clients;
    }

}