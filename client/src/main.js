import { ProductData } from "./data/product.js";
import { ProductView } from "./ui/product/index.js";
import { CategoryData} from "./data/category.js";
import { DesktopCategoryView } from "./ui/nav/desktop/category/index.js";
import { MobileCategoryView } from "./ui/nav/mobile/category/index.js";
import { navDesktopView } from "./ui/nav/desktop/index.js";
import { navMobileView } from "./ui/nav/mobile/index.js";

let V = {}

V.init = async function(){
    let vw = Math.max(document.documentElement.clientWidth || 0);

    let html = "";
    let data = await CategoryData.fetchAll();
    if (vw>700){
        navDesktopView.render();
        html = DesktopCategoryView.render(data);
    } else {        
        navMobileView.render();
        html = MobileCategoryView.render(data);
    }
    document.querySelector("#nav-categories").innerHTML = html;
    
    let navbar = document.querySelector("#navbar");
    navbar.addEventListener("click", C.handler_clickOnNavbar);
}

let C = {}

C.init = async function(){
    V.init();
}

C.handler_clickOnNavbar = function(ev){
    let nav_dropdown = document.querySelector("#nav-categories");
    let element_id = undefined;
    if (ev.target.id=="nav-burger"){
        // Clic sur le burger - seulement sur mobile
        nav_dropdown.classList.toggle("translate-y-full");
    }
    else {
        element_id = ev.target.id;
        // On vérifie si l'élément cliqué a une id (sinon c'est qu'il n'est pas censé être cliquable)
        if (element_id!="" && element_id!=undefined){
            // Clic sur le logo
            if (element_id=="nav-logo"){
                
            }
            else {
                // Clic sur une catégorie
            }
        }
    }
}

C.init();