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

C.handler_clickOnPage = async function(ev){
    let nav_dropdown = document.querySelector("#nav-categories");
    let element_id = ev.target.id;
    let data = undefined;
    let product_id = undefined;
    let option_id = undefined;
    let total = undefined;
    let quantite = undefined;
    
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

            case "nav-cart":
                // Clic sur le panier
                data = CartData.read();
                
                total = undefined;
                if (data.length == 0){
                    data = undefined;
                }
                else {
                    total = CartData.total();
                }

                V.renderCart(data, total);

                break;

            case "product-card":
                // Clic sur un produit
                // on va chercher l'id du produit (et donc de toutes les options)
                product_id = ev.target.dataset.productid;

                // on vérifie si l'élément cliqué est une option
                // si oui on récupère son id
                option_id = ev.target.dataset.optionid;

                // on va chercher les données du produit
                data = await ProductData.fetchOptions(product_id);

                // on demande à View l'affichage.
                // note : ce n'est pas grave si option_id est undefined.
                // en effet le render propre à la page produit gère ce cas
                V.renderProductPage(data, option_id);
                break;

            case "product-buy":
                // Clic sur le bouton d'achat d'un produit
                product_id = ev.target.dataset.productid;
                option_id = ev.target.dataset.optionid;

                data = await ProductData.fetchByOption(product_id, option_id);

                CartData.add(data.id, data.id_options, data.name, data.short_name, data.price, data.image, data.retailer, 1);
                break;

            case "cart-increase":
                // Clic sur le bouton d'augmentation de quantité
                product_id = ev.target.dataset.productid;
                option_id = ev.target.dataset.optionid;

                CartData.add(product_id, option_id);

                quantite = document.querySelector(`#cart-amount-` + product_id + '-' + option_id);
                quantite.innerHTML = parseFloat(quantite.innerHTML) + 1;

                total = CartData.total();
                document.querySelector("#cart-total").innerHTML = total;

                break;

            case "cart-decrease":
                // Clic sur le bouton de diminution de quantité
                product_id = ev.target.dataset.productid;
                option_id = ev.target.dataset.optionid;

                CartData.remove(option_id);

                quantite = document.querySelector(`#cart-amount-` + product_id + '-' + option_id);
                if (parseFloat(quantite.innerHTML) > 1){
                    quantite.innerHTML = parseFloat(quantite.innerHTML) - 1;
                }

                total = CartData.total();
                document.querySelector("#cart-total").innerHTML = total;

                break;

            case "cart-remove":
                // Clic sur le bouton de suppression d'un produit
                product_id = ev.target.dataset.productid;
                option_id = ev.target.dataset.optionid;

                CartData.delete(product_id, option_id);

                let product = document.querySelector(`#cart-product-` + product_id + '-' + option_id);
                product.remove();

                total = CartData.total();
                document.querySelector("#cart-total").innerHTML = total;

                let counter = document.querySelector("#cart-counter");
                counter.innerHTML = CartData.count();

                break;

        }
    }
}

C.init();