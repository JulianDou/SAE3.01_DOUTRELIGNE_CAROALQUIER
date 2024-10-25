import {getRequest} from '../lib/api-request.js';
import {postRequest} from '../lib/api-request.js';

let CartData = {};

let CartContent = [];

// CartData.clear vide le panier (et le renvoie vidé).
CartData.clear = function(){
    CartContent = [];
    return CartContent;
}

// CartData.read peut prendre en paramètre un produit spécifique.
// Il renvoie alors ce produit spécifique.
// Sinon il renvoie tout le panier.
CartData.read = function(id_produits, id_options){
    let data = CartContent;

    if (id_produits != undefined && id_options != undefined) {
        data = CartContent.filter(item => item.id == id_produits && item.id_options == id_options);
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
CartData.add = async function(id, id_options, data){
    let product = {
        id: id,
        id_options: id_options,
    }

    // On ne fournit data qu'en cas d'ajout au panier.
    if (data){
        product = data;
        product.quantite = 1;
    }

    let existingProduct = CartContent.find(item => item.id == product.id && item.id_options == product.id_options);
    
    if (existingProduct != undefined) {
        existingProduct.quantite ++;
    } else {
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


// CartData.submit envoie le panier à l'API.
// On part du principe que l'utilisateur est connecté.
// Attention, CartData.submit vide le panier.
CartData.submit = async function(){    
    if (CartContent.length > 0) {
        let data = new FormData();
        let items = CartContent.map(item => ({
            id_produits: item.id,
            id_options: item.id_options,
            quantity: item.quantite,
            price: item.price
        }));
        data.append('items', JSON.stringify(items));

        let success = false;
        let response = await postRequest('commandes', data);
        if (response){
            CartData.clear();
            success = true;
        }
        return success;
    } else {
        return false;
    }
}

CartData.getOrder = async function(){
    let data = getRequest("commandes/me");
    if (!data) {
        return [];
    }
    return data;
}


export {CartData};