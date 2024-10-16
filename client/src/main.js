import { ProductData } from "./data/product.js";
import { ProductView } from "./ui/product/index.js";
import { CategoryData} from "./data/category.js";
import { DesktopCategoryView } from "./ui/nav/desktop/category/index.js";
import { navDesktopView } from "./ui/nav/desktop/index.js";
import { navMobileView } from "./ui/nav/mobile/index.js";

let V = {}

V.init = function(){
    navbar = document.querySelector("#navbar");
    navbar.addEventListener("click", C.handler_clickOnNavbar);
}

let C = {}

C.init = async function(){
    navMobileView.render();
    // let data = await CategoryData.fetchAll();
    // let html = CategoryView.render(data);
    // document.querySelector("#nav-categories").innerHTML = html;
    V.init();
}

C.handler_clickOnNavbar = function(ev){
    let nav_dropdown = document.querySelector("#nav-categories");
    if (ev.target.id=="nav-burger"){
        nav_dropdown.classList.toggle("translate-y-full");
    }
}

C.init();