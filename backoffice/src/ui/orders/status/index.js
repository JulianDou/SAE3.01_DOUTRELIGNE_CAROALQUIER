import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/orders/status/template.html.inc");
const template = await templateFile.text();

let OrdersStatusView = {

    render: function(id, status){
        let data = {
            id_commandes: id,
            status: status
        };
        let html = genericRenderer(template, data);
        // on rend le elect en préselectionnant la valeur actuelle du status
        html = html.replace(`value="${status}"`, `value="${status}" selected`);
        return html;
    }

}

export { OrdersStatusView };