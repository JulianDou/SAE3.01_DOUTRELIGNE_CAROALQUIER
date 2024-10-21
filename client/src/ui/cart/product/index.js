import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/cart/product/template.html.inc");
const template = await templateFile.text();


let CartProductView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {CartProductView};