import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/results/product/template.html.inc");
const template = await templateFile.text();


let ResultsProductView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {ResultsProductView};