import { genericRenderer } from "../../lib/utils.js";
import { OrdersProductsView } from "./products/index.js";
import { OrdersStatusView } from "./status/index.js";

const templateFile = await fetch("src/ui/orders/template.html.inc");
const template = await templateFile.text();

let OrdersView = {
    render: function (data) {
        for (let order of data) {
            // on formate le composant parent avec l'option choisie
            let html = "";
            html += genericRenderer(template, order);

            // on prépare la section des produits
            let products = "";

            // on appelle la fonction render du composant enfant product
            for (let product of order.products) {
                products +=  OrdersProductsView.render(product);
                
            }
            
            // puis on met le html concaténé dans le template
            html = html.replace("{{product_list}}", products);

            // on rend les options du status dans le template en présélectionnant la valeur actuelle
            let status = OrdersStatusView.render(order.id_commandes, order.status);

            // puis on met le html concaténé dans le template
            html = html.replace("{{select_status}}", status);

            // et on envoie tout ça dans la target, en fonction du statut de la commande
            switch (order.status) {
                case "en_cours":
                    document.querySelector("#current-orders").innerHTML += html;
                    break;

                case "disponible":
                    document.querySelector("#current-orders").innerHTML += html;
                    break;

                case "annulee":
                    document.querySelector("#old-orders").innerHTML += html;
                    break;

                case "retiree":
                    document.querySelector("#old-orders").innerHTML += html;
                    break;
            }
        }
    },
};

export { OrdersView };