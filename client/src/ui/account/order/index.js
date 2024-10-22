import { productView } from "./product/index.js";
import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/account/order/template.html.inc");
const template = await templateFile.text();


let orderView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);

        let products = "";

        for (let product of data.products){
            products += productView.render(product);
        }

        html = html.replaceAll("{{products}}", products);

        return html;
    }

}

export {orderView};