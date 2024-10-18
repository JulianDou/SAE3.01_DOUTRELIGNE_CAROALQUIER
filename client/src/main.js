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

// imports pour les résultats
import { ResultsView } from "./ui/results/index.js";

// imports pour la page produit
import { ProductPageView } from "./ui/productpage/index.js";

let V = {}

V.init = async function(){

    // On vide la section main pour être sûr
    document.querySelector("#main").innerHTML = "";

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

    data = await ProductData.fetchAll(); // remplacer le fetch par le bon code quand on sera à la bonne itération
    PromotedView.render("#main", data);

}

V.renderResults = function(data){

    // On vide la section main puisque les composants ne le font pas
    document.querySelector("#main").innerHTML = "";
    
    // ----- Affichage Produits -----

    ResultsView.render("#main", data);

}

V.renderProductPage = function(data, option_id){

    // On vide la section main puisque les composants ne le font pas
    document.querySelector("#main").innerHTML = "";
    
    // ----- Affichage Produit -----

    ProductPageView.render("#main", data, option_id);
    
}

let C = {}

C.init = async function(){
    V.init();
}

C.handler_clickOnPage = async function(ev){
    let nav_dropdown = document.querySelector("#nav-categories");
    let element_id = ev.target.id;
    let data = undefined;

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
                V.renderHomepage();
                break;

            case "nav-category":
                // Clic sur une catégorie
                let category_id = ev.target.dataset.categoryid;
                data = await ProductData.fetchByCategory(category_id);
                V.renderResults(data);
                break;

            case "product-card":
                // Clic sur un produit
                // on va chercher l'id du produit (et donc de toutes les options)
                let product_id = ev.target.dataset.productid;

                // on vérifie si l'élément cliqué est une option
                // si oui on récupère son id
                let option_id = ev.target.dataset.optionid;

                // on va chercher les données du produit
                data = await ProductData.fetchOptions(product_id);

                // on demande à View l'affichage.
                // note : ce n'est pas grave si option_id est undefined.
                // en effet le render propre à la page produit gère ce cas
                V.renderProductPage(data, option_id);
                break;

            case "product-buy":
                // Clic sur le bouton d'achat d'un produit
                let boughtproduct_id = ev.target.dataset.productid;
                console.log("Achat d'un produit :", boughtproduct_id);
                break;

        }
    }
}

C.init();