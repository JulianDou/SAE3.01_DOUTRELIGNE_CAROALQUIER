import {getRequest} from '../lib/api-request.js';
import {postRequest} from '../lib/api-request.js';


let OrderData = {};

let fakeOrders = [
  {
    "id_commandes": 19,
    "id_clients": 16,
    "client_name": "Patapain",
    "client_email": "Patapain@hotmail.com",
    "order_date": "2024-10-23 16:51:28",
    "status": "en_cours",
    "products": [
      {
        "id_produits": 3,
        "quantity": 2,
        "price": "61.99",
        "id_options": 5,
        "name": "Manette de Xbox",
        "retailer": "Microsoft",
        "image": "manette-microsoft-rouge.jpg",
        "short_name": "Rouge"
      },
      {
        "id_produits": 4,
        "quantity": 2,
        "price": "69.99",
        "id_options": 5,
        "name": "Manette de switch",
        "retailer": "Nintendo",
        "image": "manette-nintendo-rouge.jpg",
        "short_name": "Rouge"
      }
    ]
  },
]

// On récupère une commande avec un certain ID
OrderData.fetch = async function(id) {
    let data = await getRequest('commandes/' + id);
    return data == false ? fakeOrders.pop() : [data];
}

// On récupère toutes les commandes
OrderData.fetchAll = async function() {
    let data = await getRequest('commandes');
    return data == false ? fakeOrders : data;
}

// On met à jour le status d'une commande
OrderData.updateStatus = async function(data) {
  
  // On envoie les données à l'API en utilisant postRequest
  let response = await postRequest('commandes/status', data);
  return response;
}

// On met à jour une commande
OrderData.update = async function(id, status, products) {  
  let formData = new FormData();

  formData.append('id_commandes', id);
  formData.append('status', status);
  formData.append('products', JSON.stringify(products));

  // On envoie les données à l'API en utilisant postRequest
  let response = await postRequest('commandes/update', formData);
  return response;
}

export { OrderData };