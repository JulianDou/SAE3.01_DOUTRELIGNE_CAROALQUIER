import { productView } from "./product/index.js";
import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/account/order/template.html.inc");
const template = await templateFile.text();


let orderView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);

        let status = data.status;
        let status_new = "";
        switch (status) {
            case "disponible":
                status_new = "Disponible";
                break;

            case "en_cours":
                status_new = "En cours";
                break;

            case "annulee":
                status_new = "Annulée";
                break;

            case "retiree":
                status_new = "Retirée";
                break;
        }
        html = html.replace("{{order_status}}", status_new);

        let products = "";
        let total = 0;
        let product_price = 0;

        for (let product of data.products){
            product_price = product.price * product.quantity;
            total += product_price;
            products += productView.render(product);
        }

        html = html.replace("{{total}}", total);
        html = html.replaceAll("{{products}}", products);

        return html;
    }

}

export {orderView};