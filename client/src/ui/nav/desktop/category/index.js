import { genericRenderer } from "../../../../lib/utils.js"; 

const templateFile = await fetch("src/ui/nav/desktop/category/template.html.inc");
const template = await templateFile.text();


let DesktopCategoryView = {

    render: function(data){
        let html = "";
        for(let obj of data){
            html += genericRenderer(template, obj);
        }
        return html;
    }

}

export {DesktopCategoryView};