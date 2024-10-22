import { ProductData } from "./data/product.js";
import { CategoryData} from "./data/category.js";
import { CartData } from "./data/cart.js";

// imports pour la nav
import { navView } from "./ui/nav/index.js";

// imports pour les catégories
import { CategoriesView} from "./ui/categories/index.js";

// imports pour les produits en vogue
import { PromotedView } from "./ui/promoted/index.js";

// imports pour les résultats
import { ResultsView } from "./ui/results/index.js";

// imports pour la page produit
import { ProductPageView } from "./ui/productpage/index.js";

// imports pour le panier
import { CartView } from "./ui/cart/index.js";


let V = {}

// V.init a besoin d'un paramètre pour éviter des appels Model dans View
// C'est Controller, quand il appelle V.init, va lui donner les données des catégories de la nav
V.init = async function(nav_data){

    // On vide la section main pour être sûr
    document.querySelector("#main").innerHTML = "";

    // ----- Affichage Nav -----

    navView.render(nav_data);

    // ajout d'un event listener pour la nav
    let nav = document.querySelector("#navbar");
    nav.addEventListener("click", C.handler_clickOnNav);
    
    // ajout d'un event listener pour le main
    let main = document.querySelector("#main");
    main.addEventListener("click", C.handler_clickOnMain);

    // ajout d'un event listener pour le paneau latéral
    let sidepanel = document.querySelector("#side-panel");
    sidepanel.addEventListener("click", C.handler_clickOnSidepanel);

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

V.renderCart = function(data, total){    

    let overlay = document.querySelector("#dark-overlay");
    overlay.classList.toggle("hidden");

    let side_panel = document.querySelector("#side-panel");
    side_panel.classList.toggle("translate-x-full");
    if (side_panel.innerHTML == ""){
        CartView.render("#side-panel", data, total);
    }
    else {
        side_panel.innerHTML = "";
    }

}

let C = {}

C.init = async function(){    
    let nav_data = await CategoryData.fetchAll();
    V.init(nav_data);
}

C.handler_clickOnMain = async function(ev) {
    let element_id = ev.target.id;
    let data = undefined;
    let product_id = undefined;
    let option_id = undefined;

    if (element_id != "" && element_id != undefined) {
        switch (element_id) {
            case "product-card":
                product_id = ev.target.dataset.productid;
                option_id = ev.target.dataset.optionid;
                data = await ProductData.fetchOptions(product_id);
                V.renderProductPage(data, option_id);
                break;

            case "product-buy":
                product_id = ev.target.dataset.productid;
                option_id = ev.target.dataset.optionid;
                data = await ProductData.fetchByOption(product_id, option_id);
                CartData.add(data.id, data.id_options, data.name, data.short_name, data.price, data.image, data.retailer, 1);
                let count = CartData.count();
                document.querySelector("#cart-notification").classList.remove("hidden");
                document.querySelector("#cart-notification").innerHTML = count;
                break;
        }
    }
}

C.handler_clickOnNav = async function(ev) {
    let nav_dropdown = document.querySelector("#nav-categories");
    let element_id = ev.target.id;
    let data = undefined;

    if (element_id != "" && element_id != undefined) {
        switch (element_id) {
            case "nav-burger":
                nav_dropdown.classList.toggle("translate-y-full");
                break;

            case "nav-logo":
                V.renderHomepage();
                break;

            case "nav-category":
                let category_id = ev.target.dataset.categoryid;
                data = await ProductData.fetchByCategory(category_id);
                V.renderResults(data);
                break;

            case "nav-cart":
                data = CartData.read();
                let total = undefined;
                if (data.length == 0) {
                    data = undefined;
                } else {
                    total = CartData.total();
                }
                V.renderCart(data, total);
                break;
        }
    }
}

C.handler_clickOnSidepanel = function(ev) {
    let element_id = ev.target.id;
    let product_id = ev.target.dataset.productid;
    let option_id = ev.target.dataset.optionid;

    if (element_id != "" && element_id != undefined) {
        switch (element_id) {
            case "nav-cart":
                C.updateCartView();
                break;

            case "cart-increase":
                CartData.add(product_id, option_id);
                CartView.updateItem(product_id, option_id, 1, CartData.count(), CartData.total());
                break;

            case "cart-decrease":
                CartData.remove(product_id, option_id);
                CartView.updateItem(product_id, option_id, -1, CartData.count(),CartData.total());
                break;

            case "cart-remove":
                CartData.delete(product_id, option_id);
                CartView.removeItem(product_id, option_id, CartData.count(), CartData.total());
                break;
        }
    }
}

C.updateCartView = function() {
    let data = CartData.read();
    let total = undefined;

    if (data.length == 0) {
        data = undefined;
    } else {
        total = CartData.total();
    }

    V.renderCart(data, total);
}

C.init();