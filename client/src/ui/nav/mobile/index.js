const templateFile = await fetch("src/ui/nav/mobile/template.html.inc");
const template = await templateFile.text();

let navMobileView = {

    render: function(){
        document.querySelector("header").innerHTML = template;
    },

}

export {navMobileView};