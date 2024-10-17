import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/categories/category/template.html.inc");
const template = await templateFile.text();


let CategoryView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {CategoryView};