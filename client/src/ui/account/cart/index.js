import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/account/cart/template.html.inc");
const template = await templateFile.text();


let accountCartView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {accountCartView};