const templateFile = await fetch("src/ui/nav/mobile/template.html.inc");
const template = await templateFile.text();

let navMobileView = {

    render: function(){
        document.querySelector("#navbar").innerHTML = template;
    },

}

export {navMobileView};