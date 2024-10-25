import {getRequest} from '../lib/api-request.js';


let ProductData = {};

let fakeProducts = [
    {
        id: 1,
        name: "Example Product",
        retailer: "Example Retailer",
        img: "controllertest.jpg",
        price: "99.99"
    },
    {
        id: 2,
        name: "Example Product 2",
        retailer: "Example Retailer 2",
        img: "controllertest.jpg",
        price: "999.99"
    }
]

ProductData.fetch = async function(id){
    let data = await getRequest('products/'+id);
    return data==false ? fakeProducts.pop() : [data];
}

ProductData.fetchOptions = async function(id){
    let data = await getRequest('options/'+id);
    return data==false ? fakeProducts : data;
}

ProductData.fetchAll = async function(){
    let data = await getRequest('products');
    return data==false ? fakeProducts : data;
}

ProductData.fetchByCategory = async function(categoryid){
    let data = await getRequest('products?category='+categoryid);
    return data==false ? fakeProducts : data;
}

export {ProductData};