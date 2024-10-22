import {orderView} from "./order/index.js";

const templateFile = await fetch("src/ui/account/template.html.inc");
const template = await templateFile.text();

let navView = {

    render: function(data, target){
        // on inverse data de sorte à avoir les plus récentes en premier
        data = data.reverse();

        // on prépare le HTML de toutes les commandes, et un nouveau template modifiable
        let template_new = template.replace("{{client_name}}", "fantastique humain (placeholder)");
        let lastorderdata = data[0];
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
        if (data.length > 1){
            // on enlève la première commande de la liste (vu qu'on l'a déjà formatée)
            data.shift();

            // on appelle la fonction render propre aux commandes, pour chaque commande
            for (let order of data){
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
    }

}

export {navView};