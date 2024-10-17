const templateFile = await fetch("src/ui/nav/desktop/template.html.inc");
const template = await templateFile.text();


let navDesktopView = {

    render: function(){
        document.querySelector("#navbar").innerHTML = template;
    },

}

export {navDesktopView};