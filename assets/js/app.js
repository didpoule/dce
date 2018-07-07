import 'bootstrap';
import 'lightbox2';
import 'trumbowyg';

import Posts from './components/Posts';
import Galleries from './components/Galleries';
import Gallery from './components/Gallery';
import Events from './components/Events';
import Formulas from "./components/Formulas";

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

        let post = new Posts();
        let galleries = new Galleries();
        let gallery = new Gallery();
        let events = new Events();
        let formulas = new Formulas($("#event_formulas"));

    }

    run() {

    }
}

$(document).ready(function () {
    let app = new App();
    app.run();
});
