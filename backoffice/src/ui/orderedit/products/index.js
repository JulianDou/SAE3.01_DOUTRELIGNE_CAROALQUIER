import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/orderedit/products/template.html.inc");
const template = await templateFile.text();

let EditOrdersProductsView = {

    render: function(data, number){
        let html = "";
        html += genericRenderer(template, data);
        html = html.replace("{{number}}", number);
        return html;
    }

}

export { EditOrdersProductsView };