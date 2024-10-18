import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/productpage/option/template.html.inc");
const template = await templateFile.text();


let ProductPageOptionView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {ProductPageOptionView};