import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/promoted/product/template.html.inc");
const template = await templateFile.text();


let PromotedProductView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {PromotedProductView};