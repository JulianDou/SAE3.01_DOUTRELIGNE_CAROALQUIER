import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/account/order/product/template.html.inc");
const template = await templateFile.text();


let productView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {productView};