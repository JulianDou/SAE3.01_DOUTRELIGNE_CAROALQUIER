import { genericRenderer } from "../../lib/utils.js";
import { EditOrdersProductsView } from "./products/index.js";
import { EditOrdersStatusView } from "./status/index.js";

const templateFile = await fetch("src/ui/orderedit/template.html.inc");
const template = await templateFile.text();

let EditOrdersView = {
    render: function (data) {
        data = data[0];
        // on formate le composant parent avec l'option choisie
        let html = "";
        html += genericRenderer(template, data);

        // on prépare la section des produits
        let products = "";
        let number = 1;

        // on appelle la fonction render du composant enfant product
        for (let product of data.products) {
            products += EditOrdersProductsView.render(product, number);
            number ++;
        }
        
        // puis on met le html concaténé dans le template
        html = html.replace("{{product_list}}", products);

        // on rend les options du status dans le template en présélectionnant la valeur actuelle
        let status = EditOrdersStatusView.render(data.id_commandes, data.status);

        // puis on met le html concaténé dans le template
        html = html.replace("{{select_status}}", status);

        // et on envoie tout ça dans le body
        document.querySelector("body").innerHTML += html;
    },
};

export { EditOrdersView };