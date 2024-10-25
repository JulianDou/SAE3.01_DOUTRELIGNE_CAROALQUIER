import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/orders/products/template.html.inc");
const template = await templateFile.text();

let OrdersProductsView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);

        return html;
    }

}

export { OrdersProductsView };