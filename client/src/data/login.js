import {postRequest} from '../lib/api-request.js';


let LoginData = {};

LoginData.userinfo = {
    email: undefined,
    name: undefined,
    verified: false,
}

// LoginData.login fait une requête de connection à l'API.
// On renvoie les données obtenues ;
// Attention, il faudra faire le tri au cas où la requête échoue (login ne renvoie rien).
LoginData.login = async function(email, password){
    let data = new FormData();
    data.append('email', email);
    data.append('password', password);

    let response = await postRequest('clients/signin', data);
    return response;
};

// LoginData.logout fait une requête de déconnection à l'API.
// On réinitialise les données de l'utilisateur.
// On renvoie true si la requête a réussi, false sinon.
LoginData.logout = async function(){
    let response = await postRequest('clients/signout');
    if (response){
        LoginData.userinfo.email = undefined;
        LoginData.userinfo.name = undefined;
        LoginData.userinfo.verified = false;
        return true;
    } else {
        return false;
    }
};

// LoginData.save enregistre les données de l'utilisateur connecté.
// On part du principe qu'on ne le fait qu'à partir de données que le serveur nous a fourni,
// et que celles-ci sont bien formatées.
// On renvoie les données à fins d'éventuelles vérifications.
LoginData.save = function (data){
    LoginData.userinfo.email = data.email;
    LoginData.userinfo.name = data.name;
    LoginData.userinfo.verified = true;
    return LoginData.userinfo;
}

export {LoginData};