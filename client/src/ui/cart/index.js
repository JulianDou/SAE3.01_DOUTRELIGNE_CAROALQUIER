import { CartProductView } from "./product/index.js";

const templateFile = await fetch("src/ui/cart/template.html.inc");
const template = await templateFile.text();

let CartView = {

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
        document.querySelector(target).innerHTML += template_new;
    },

}

export { CartView };
