import {getRequest} from '../lib/api-request.js';


let CartData = {};

let CartContent = [];

/*
format CartContent :

[
    {
        userid: 1,
        products:[
            1,
            2,
            etc.
        ]
    }
]

*/

CartData.init = function(data){
    CartContent = data;
}

CartData.read = async function(id){
    let data = await getRequest('category/'+id);
    return data==false ? fakeCategories.pop() : [data];
}

CartData.write = async function(){
    let data = await getRequest('categories');
    return data==false ? fakeCategories : data;
}


export {CartData};