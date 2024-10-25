import { OrdersView } from "./ui/orders/index.js";

import { OrderData } from "./data/orders.js";

import { EditOrdersView } from "./ui/orderedit/index.js";

let V = {}

V.init = async function(){
    // On vide les listes pour être sûr
    document.querySelector("#current-orders").innerHTML = "";
    document.querySelector("#old-orders").innerHTML = "";

    // Affichage des commandess
    let orders = await OrderData.fetchAll();
    OrdersView.render(orders);

    // Ajout d'un event listener pour les selects
    let ordersList = document.querySelector("#current-orders");
    ordersList.addEventListener("change", C.handler_updateSelectedStatus);
    ordersList.addEventListener("click", C.handler_editOrder);
    let oldOrdersList = document.querySelector("#old-orders");
    oldOrdersList.addEventListener("change", C.handler_updateSelectedStatus);
    oldOrdersList.addEventListener("click", C.handler_editOrder);

    // Ajout de l'event listener pour l'édition des commandes
    let body = document.querySelector("body");
    body.addEventListener("click", C.handler_editOrderButtons);

}

let C = {}

C.init = async function(){
    V.init();
}

C.handler_editOrder = async function(ev){
    let element_id = ev.target.id;
    let order_id = ev.target.dataset.orderid;

    if (element_id != "" && element_id != undefined) {
        switch (element_id) {
            case "edit-order":
                let data = await OrderData.fetch(order_id);
                EditOrdersView.render(data);
                break;
        }
    }
}

C.handler_updateSelectedStatus = async function(ev){
    // On récupère les données de l'élément cliqué
    let id_commandes = ev.target.dataset.id_commandes;

    // On récupère la valeur de l'option choisie
    let status = ev.target.value;
    let data = {
        id_commandes: id_commandes,
        status: status
    };

    await OrderData.updateStatus(data);

    // on déplace l'élément cliqué
    let li = ev.target.closest("li");
    let li_copy = li.cloneNode(true);
    let current_orders = document.querySelector("#current-orders");
    let old_orders = document.querySelector("#old-orders");

    switch (status) {
        case "en_cours":
            li.remove();
            li_copy.querySelector(`option[value="${status}"]`).selected = true;
            current_orders.insertBefore(li_copy, Element.firstChild);
            break;
        case "disponible":
            li.remove();
            li_copy.querySelector(`option[value="${status}"]`).selected = true;
            current_orders.insertBefore(li_copy, Element.firstChild);
            break;
        case "annulee":
            li.remove();
            li_copy.querySelector(`option[value="${status}"]`).selected = true;
            old_orders.insertBefore(li_copy, Element.firstChild);
            break;
        case "retiree":
            li.remove();
            li_copy.querySelector(`option[value="${status}"]`).selected = true;
            old_orders.insertBefore(li_copy, Element.firstChild);
            break;
    }
}

C.handler_editOrderButtons = async function(ev){
    let element_id = ev.target.id;

    if (element_id == "edit-cancel" || element_id == "edit-submit") {

        let form = document.querySelector("#edit-form");
        let id_commandes = form.dataset.id;
        let status = document.querySelector("#status-edit-" + id_commandes).value;

        switch (element_id) {
            case "edit-cancel":

                location.reload();
                break;
            
            case "edit-submit":
                let products = document.querySelectorAll("#product-edit");

                let items = [];
                products.forEach(product => {
                    let id_produits = product.dataset.id_produits;
                    let id_options = product.dataset.id_options;
                    let quantity = document.querySelector("#product-amount-" + id_produits + "-" + id_options).value;

                    let item = {
                        id_produits: id_produits,
                        quantity: quantity,
                        id_options: id_options,
                    };

                    items.push(item);
                });

                let result = await OrderData.update(id_commandes, status, items);
                if (result == false){
                    alert("Erreur lors de la mise à jour de la commande");
                    break;
                }
                else {
                    location.reload();
                    break;
                }
                
        }
    }
}

C.init();

