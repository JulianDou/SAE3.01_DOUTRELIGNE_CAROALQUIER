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
CartData.read = function(id){
    let data = CartContent;

    if (id != undefined){
        data = CartContent.filter(item => item.id == id);
    }

    if (data.length == 0){
        return "Erreur : produit non trouvé";
    }
    else {
        return data;
    }
}

// CartData.add ajoute un produit au panier, OU augmente sa quantité
// si celui ci était déjà présent.
// Il renvoie le panier après ajout.
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

    if (CartContent.filter(item => item.id == id).length == 0){
        CartContent.push(product);
    }
    else {
        CartContent = CartContent.map(item => {
            if (item.id == id){
                item.quantite ++;
            }
            return item;
        });
    }
    return CartContent;
}

// CartData.remove diminue la quantité d'un produit dans le panier.
CartData.remove = function(id){
    if (CartContent.filter(item => item.id == id).length == 0){
        return "Erreur : produit non trouvé";
    }
    else {
        CartContent = CartContent.map(item => {
            if (item.id == id && item.quantite > 1){
                item.quantite --;
            }
            return item;
        });
        return CartContent;
    }
}

// CartData.delete supprime un produit du panier.
// Il renvoie le panier après suppression.
CartData.delete = function(id){
    CartContent = CartContent.filter(item => item.id != id);
    return CartContent;
}

// CartData.total renvoie le montant total du panier.
CartData.total = function(){
    let total = 0;
    CartContent.forEach(item => {
        total += item.price * item.quantite;
    });
    return total;
}


export {CartData};