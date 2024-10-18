import { ResultsProductView } from "./product/index.js";

const templateFile = await fetch("src/ui/results/template.html.inc");
const template = await templateFile.text();


let ResultsView = {

    render: function(target, data){
        // on prépare le HTML de toutes les cartes, et un nouveau template modifiable
        let template_new = template;
        let products = "";

        // on appelle la fonction render propre aux cartes, pour chaque carte
        for (let product of data){
            products += ResultsProductView.render(product);
        }

        // puis on met le html concaténé dans le template
        template_new = template_new.replace("{{products}}", products);

        // et on envoie tout ça dans la target choisie
        document.querySelector(target).innerHTML += template_new;
    },

}

export {ResultsView};