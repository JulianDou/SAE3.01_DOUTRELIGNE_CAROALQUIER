import {getRequest} from '../lib/api-request.js';


let CartData = {};

let CartContent = [];

/*
format CartContent :

[
    {
        "id": 1,
        "id_options": 7
        "name": "Produit 1",
        "short_name": "Bleu",
        "price": 9.99,
        "image": "produit1.jpg",
        "retailer": "Amazon",
        "quantite": 1
    },
    etc...
]

*/

// CartData.clear vide le panier (et le renvoie vidé).
CartData.clear = function(){
    CartContent = [];
    return CartContent;
}

// CartData.read peut prendre en paramètre un produit spécifique.
// Il renvoie alors ce produit spécifique.
// Sinon il renvoie tout le panier.
CartData.read = function(id_options){
    let data = CartContent;

    if (id_options != undefined){
        data = CartContent.filter(item => item.id_options == id_options);
    }

    if (data.length == 0){
        return [];
    }
    else {
        return data;
    }
}

// CartData.add ajoute un produit au panier, OU augmente sa quantité
// si celui ci était déjà présent.
// Il renvoie le panier après ajout.
// On utilise l'id de l'option plutôt que l'id du produit en général.
CartData.add = async function(id, id_options, name, short_name, price, image, retailer, quantite){
    let product = {
        "id": id,
        "id_options": id_options,
        "name": name,
        "short_name": short_name,
        "price": price,
        "image": image,
        "retailer": retailer,
        "quantite": quantite
    };

    let existingProduct = CartContent.find(item => item.id == product.id && item.id_options == product.id_options);
    
    if (existingProduct != undefined) {
        existingProduct.quantite ++;
    } else {

        for (let key in product) {
            if (product[key] === undefined) {
                console.log("Erreur : produit invalide");
                return "Erreur : produit invalide";
            }
        }

        CartContent.push(product);
    }
    return CartContent;
}

// CartData.remove diminue la quantité d'un produit dans le panier.
CartData.remove = function(id, id_options){
    if (CartContent.filter(item => item.id == id && item.id_options == id_options).length == 0){
        return "Erreur : produit non trouvé";
    }
    else {
        CartContent = CartContent.map(item => {
            if (item.id == id && item.id_options == id_options && item.quantite > 1){
                item.quantite --;
            }
            return item;
        });
        return CartContent;
    }
}

// CartData.delete supprime un produit du panier.
// Il renvoie le panier après suppression.
CartData.delete = function(id, id_options){
    CartContent = CartContent.filter(item => !(item.id == id && item.id_options == id_options));
    return CartContent;
}

// CartData.total renvoie le montant total du panier.
// Attention, le total est arrondi à 2 chiffres après la virgule.
CartData.total = function(){
    let total = 0;
    CartContent.forEach(item => {
        total += item.price * item.quantite;
    });
    return total.toFixed(2);
}

// CartData.count renvoie le nombre total de produits (individuels) dans le panier.
CartData.count = function(){
    return CartContent.length;
}


export {CartData};