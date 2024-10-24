import { genericRenderer } from "../../lib/utils.js"; 
import { ProductPageOptionView } from "./option/index.js";

const templateFile = await fetch("src/ui/productpage/template.html.inc");
const template = await templateFile.text();

let ProductPageView = {
    
    render: function(target, data, targetoption){

        let index = 0;
        // si on a pas demandé d'option, on prend la première
        if (targetoption == undefined) {
            index = 0;
        }
        else {
            // on va chercher l'index de l'option recherchée
            index = data.findIndex((element) => element.id_options == targetoption);
        }

        // on formate le composant parent avec l'option choisie
        let html = "";
        html += genericRenderer(template, data[index]);

        // on prépare les options et on retire l'option choisie
        let options = "";
        data.splice(index, 1);

        // on appelle la fonction render propre aux options, pour chaque option
        for (let product of data){
            options += ProductPageOptionView.render(product);
        }

        // puis on met le html concaténé dans le template
        html = html.replace("{{options}}", options);

        // et on envoie tout ça dans la target choisie
        document.querySelector(target).innerHTML += html;

        // gestion du stock
        let stock = document.querySelector("#product-stock").dataset.stock;
        if (stock == 0) {
            document.querySelector("#product-buy").classList.add("hidden");
            document.querySelector("#product-buy-off").classList.remove("hidden");
            document.querySelector("#product-alert").classList.remove("hidden");
            document.querySelector("#product-outofstock").classList.remove("hidden");
        }
        else if (stock < 5) {
            document.querySelector("#product-fewleft").classList.remove("hidden");
        }
        else {
            document.querySelector("#product-instock").classList.remove("hidden");
        }
    },

}

export {ProductPageView};
