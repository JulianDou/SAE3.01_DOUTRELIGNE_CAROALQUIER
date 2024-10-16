import {getRequest} from '../lib/api-request.js';


let CategoryData = {};

let fakeCategories = [
    {
        id: 1,
        icon: "./src/assets/games.svg",
        name: "Jeux Vidéos",
    },
    {
        id: 2,
        icon: "./src/assets/controller.svg",
        name: "Manettes",
    },
    {
        id: 3,
        icon: "./src/assets/goodies.svg",
        name: "Produits Dérivés",
    }
]

CategoryData.fetch = async function(id){
    let data = await getRequest('category/'+id);
    return data==false ? fakeCategories.pop() : [data];
}

CategoryData.fetchAll = async function(){
    let data = await getRequest('category');
    return data==false ? fakeCategories : data;
}


export {CategoryData};