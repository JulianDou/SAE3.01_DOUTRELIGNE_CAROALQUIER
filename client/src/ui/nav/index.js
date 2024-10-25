import {navCategoryView} from "./category/index.js";

const templateFile = await fetch("src/ui/nav/template.html.inc");
const template = await templateFile.text();

let navView = {

    render: function(data){
        // on prépare le HTML de toutes les cartes, et un nouveau template modifiable
        let template_new = template;
        let categories = "";

        // on appelle la fonction render propre aux cartes, pour chaque carte
        for (let category of data){
            categories += navCategoryView.render(category);
        }

        // puis on met le html concaténé dans le template
        template_new = template_new.replaceAll("{{categories}}", categories);

        // et on envoie tout ça dans la target choisie
        document.querySelector("#navbar").innerHTML += template_new;
    }

}

export {navView};