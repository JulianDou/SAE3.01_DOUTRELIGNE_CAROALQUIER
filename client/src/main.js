import { ProductData } from "./data/product.js";
import { ProductView } from "./ui/product/index.js";
import { CategoryData} from "./data/category.js";
import { CategoryView } from "./ui/nav/category/index.js";
import { navDesktopView } from "./ui/nav/desktop/index.js";

let C = {}

C.init = async function(){
    // navDesktopView.render();
    // let data = await CategoryData.fetchAll();
    // let html = CategoryView.render(data);
    // document.querySelector("#nav-categories").innerHTML = html;
}



C.init();