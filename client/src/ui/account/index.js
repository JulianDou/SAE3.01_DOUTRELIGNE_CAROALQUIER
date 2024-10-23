import { orderView } from "./order/index.js";
import { accountCartView } from "./cart/index.js";

const templateFile = await fetch("src/ui/account/template.html.inc");
const template = await templateFile.text();

let accountView = {

    render: function(ordersdata, logindata, target, cart){

        // on inverse orders de sorte à avoir les plus récentes en premier
        if (ordersdata){
            ordersdata.reverse();
        }

        // on prépare le HTML de toutes les commandes, et un nouveau template modifiable
        let template_new = template.replace("{{name}}", logindata.name);
        let lastorderdata = ordersdata[0];
        
        // on utilise CartView pour générer un panier dans la page
        template_new = template_new.replace("{{products}}", accountView.renderCart(cart));

        let lastorder = "";
        let orders = "";

        // on formatte la première commande
        if (lastorderdata != undefined){
            lastorder = orderView.render(lastorderdata);
        }
        else {
            lastorder = "Vous n'avez pas passé de commandes.";
        }

        // si on avait plus qu'une commande :
        if (ordersdata.length > 1){
            // on enlève la première commande de la liste (vu qu'on l'a déjà formatée)
            ordersdata.shift();

            // on appelle la fonction render propre aux commandes, pour chaque commande
            for (let order of ordersdata){
                orders += orderView.render(order);
            }
        }
        else {
            orders = "Vous n'avez pas d'autres commandes.";
        }

        // puis on met le html concaténé dans le template
        template_new = template_new.replaceAll("{{lastorder}}", lastorder);
        template_new = template_new.replaceAll("{{orders}}", orders);

        // et on envoie tout ça dans la target choisie
        document.querySelector(target).innerHTML += template_new;
    },

    // renderCart formatte une liste de produits et la renvoie en HTML.
    renderCart: function(data){
        let cartItems = "";
        let html = "";

        if (data != undefined && data.length > 0){

            // Call the render function specific to cart items for each item
            for (let item of data){
                cartItems += accountCartView.render(item);
            }
    
            // Insert the concatenated HTML into the template
            html = cartItems;
        }
        else {
            html = "Votre panier est vide.";
        }
        return (html);
    },

}

export {accountView};