import { ProductData } from "./data/product.js";
import { CategoryData} from "./data/category.js";

// imports pour la nav
import { DesktopCategoryView } from "./ui/nav/desktop/category/index.js";
import { MobileCategoryView } from "./ui/nav/mobile/category/index.js";
import { navDesktopView } from "./ui/nav/desktop/index.js";
import { navMobileView } from "./ui/nav/mobile/index.js";

// imports pour les catégories
import { CategoriesView} from "./ui/categories/index.js";

// imports pour les produits en vogue
import { PromotedView } from "./ui/promoted/index.js";

let V = {}

V.init = async function(){



    // ----- Affichage Nav -----

    // on récupère la largeur de l'écran
    let vw = Math.max(document.documentElement.clientWidth || 0);

    // affichage de la nav en fonction de l'écran
    let htmlnav = "";
    let data = await CategoryData.fetchAll();
    if (vw>700){
        navDesktopView.render();
        htmlnav = DesktopCategoryView.render(data);
    } else {        
        navMobileView.render();
        htmlnav = MobileCategoryView.render(data);
    }
    document.querySelector("#nav-categories").innerHTML = htmlnav;
    
    // ajout d'un event listener pour les clics
    let body = document.querySelector("body");
    body.addEventListener("click", C.handler_clickOnPage);

    // ----------

    V.renderHomepage();

}

V.renderHomepage = async function(){
    // On vide la section main puisque les composants ne le font pas

    document.querySelector("#main").innerHTML = "";
    let data = undefined;

    // ----- Affichage Catégories -----

    data = await CategoryData.fetchAll();
    CategoriesView.render("#main", data);

    // ----- Affichage Produits en vogue -----

    data = await ProductData.fetchAll(); // remplacer le fetchAll par le bon code quand on sera la bonne itération
    PromotedView.render("#main", data);

}

let C = {}

C.init = async function(){
    V.init();
}

C.handler_clickOnPage = function(ev){
    let nav_dropdown = document.querySelector("#nav-categories");
    let element_id = ev.target.id;

    // On vérifie si l'élément cliqué a une id (sinon c'est qu'il n'est pas censé être cliquable)
    if (element_id!="" && element_id!=undefined){
        switch (element_id) {

            case "nav-burger":
                // Clic sur le burger - seulement sur mobile
                nav_dropdown.classList.toggle("translate-y-full");
                break;

            case "nav-logo":
                // Clic sur le logo
                // On "revient" sur l'accueil
                console.log("Clic sur le logo");

                break;

            case "nav-category":
                // Clic sur une catégorie
                console.log("Clic sur une catégorie :", ev.target.dataset.categoryid);
                break;
            
        }
    }
}

C.init();