const templateFile = await fetch("src/ui/login/template.html.inc");
const template = await templateFile.text();

let LoginView = {

    render: function(target){
        // Send everything to the chosen target
        document.querySelector(target).innerHTML += template;
    },

}

export { LoginView };
