import { CartProductView } from "./product/index.js";

const templateFile = await fetch("src/ui/cart/template.html.inc");
const template = await templateFile.text();

let CartView = {

    // render formatte l'élément panier tel qu'il figure dans le menu déployant, à droite.
    // Il ne renvoie pas de html ; il s'affiche directement.
    render: function(target, data, total){

        // Prepare the HTML for all cart items and a new modifiable template
        let template_new = template;
        let cartItems = "";

        if (data != undefined){
            template_new = template_new.replace("{{cart.length}}", data.length);
            template_new = template_new.replace("{{total}}", total);   

            // Call the render function specific to cart items for each item
            for (let item of data){
                cartItems += CartProductView.render(item);
            }
    
            // Insert the concatenated HTML into the template
            template_new = template_new.replace("{{products}}", cartItems);
        }
        else {
            template_new = template_new.replace("{{cart.length}}", 0);
            template_new = template_new.replace("{{total}}", 0);   
            template_new = template_new.replace("{{products}}", "Votre panier est vide.");
        }

        // Send everything to the chosen target
        document.querySelector(target).innerHTML = template_new;
    },

    updateItem: function(product_id, option_id, quantityChange, count, total) {
        let quantite = document.querySelector(`#cart-amount-` + product_id + '-' + option_id);
        let newQuantity = parseFloat(quantite.innerHTML) + quantityChange;
        let remove = false;
    
        if (newQuantity <= 0) {
            // on renvoie (à la fin) true, pour signaler au Controller qu'il faut supprimer l'article.
            remove = true;
        } else {
            quantite.innerHTML = newQuantity;
    
            // Update the cart total
            document.querySelector("#cart-total").innerHTML = total;
        }
    
        if (count == 0) {
            document.querySelector("#cart-notification").classList.add("hidden");
        } else {
            document.querySelector("#cart-notification").classList.remove("hidden");
        }
        
        return remove;
    },

    removeItem: function(product_id, option_id, count, total) {
        let product = document.querySelectorAll(`#cart-product-` + product_id + '-' + option_id);
        product.forEach(item => item.remove());
    
        document.querySelector("#cart-total").innerHTML = total;
    
        document.querySelector("#cart-counter").innerHTML = count;
        document.querySelector("#cart-notification").innerHTML = count;
    
        if (count == 0) {
            document.querySelector("#cart-notification").classList.add("hidden");
        }    
    },

}

export { CartView };
