import 'bootstrap';
import 'lightbox2';
import trumbowyg from 'trumbowyg/dist/trumbowyg';
import colors from "trumbowyg/dist/plugins/colors/trumbowyg.colors";
import icons from "trumbowyg/dist/ui/icons.svg"

import Posts from './components/Posts';
import Galleries from './components/Galleries';
import Gallery from './components/Gallery';
import Events from './components/Events';
import Formulas from "./components/Formulas";
import Teammates from "./components/Teammates";
import Home from "./components/Home";

class App {

    constructor() {
        let form = $('.dce-form');
        let pictures = $(".galerie img");
        pictures.each(function () {
            $(this).height(this.width);
        });

        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 4000);

        $('#booking-button').on('click', null, function () {
            form.removeAttr('hidden');
            form.show();
        });

        let home = new Home();
        let post = new Posts();
        let galleries = new Galleries();
        let gallery = new Gallery();
        let events = new Events();
        let formulas = new Formulas($("#event_formulas"));
        let teammates = new Teammates($("#team_teammates"));

        $('#admin-form textarea').trumbowyg({
            lang: 'fr',
            imageWidthModalEdit: true,
            svgPath: icons,
            btns: [
                ['fontsize'],
                ['foreColor', 'backColor'],
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['link'],
                ['insertImage'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
                ['fullscreen']
            ],
        });

    }

    run() {

    }
}

$(document).ready(function () {
    let app = new App();
    app.run();
});
