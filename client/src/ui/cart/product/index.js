import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/cart/product/template.html.inc");
const template = await templateFile.text();


let CartProductView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);

        let stockleft = data.stock - 1;
        html = html.replace("{{stockleft}}", stockleft);
        if (stockleft > 5){
            html = html.replace("{{stockhidden}}", "hidden");
        }
        else {
            html = html.replace("{{stockhidden}}", "");
        }

        return html;
    }

}

export {CartProductView};