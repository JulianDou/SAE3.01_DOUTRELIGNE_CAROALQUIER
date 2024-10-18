import { genericRenderer } from "../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/nav/category/template.html.inc");
const template = await templateFile.text();


let navCategoryView = {

    render: function(data){
        let html = "";
        html += genericRenderer(template, data);
        return html;
    }

}

export {navCategoryView};