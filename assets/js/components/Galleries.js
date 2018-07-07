import Component from "../Component";

export default class Galleries extends Component {

    constructor() {
        super($("#list-galleries"));
        this.datas = ($("#galleries-datas"));
        this.url = this.datas.data('url');
        this.pages = $(".galleries-page");

        this.count = this.datas.data('count');
        this.limit = 5;
        this.current = 0;

        this.nbPages = Math.ceil(this.count / this.limit);

        this.attachEvents();

    }

    goTo(that, page) {

        let $this = that;

        if (page >= 0 && page <= $this.nbPages && page !== $this.current) {
            $this.current = page;
        }

        $.ajax({
            url: $this.url + '/' + $this.current
        }).done(function (datas) {

            let galleries = JSON.parse(datas);
            $this.updateContent(galleries);
        });

    }

    next(that) {
        let $this = that;

        if (($this.current + 1) < $this.nbPages) {
            $this.current++;

            $.ajax({
                url: $this.url + '/' + $this.current
            }).done(function (datas) {

                let galleries = JSON.parse(datas);
                $this.updateContent(galleries);
            })
        }

    }

    previous(that) {
        let $this = that;

        if (($this.current - 1) >= 0) {
            $this.current--;

            $.ajax({
                url: $this.url + '/' + $this.current
            }).done(function (datas) {
                let galleries = JSON.parse(datas);
                $this.updateContent(galleries);
            })
        }

    }

    attachEvents() {
        $(".galleries-next a").on('click', () => this.next((this)));
        $(".galleries-prev a").on('click', () => this.previous((this)));

        let $this = this;
        this.pages.on('click',  function() {
            $this.goTo($this, $(this).data('page'));
        })
    }

    updateContent(datas) {
        let items = [];

        datas.forEach((key, val) => {
            let extract = [];

            let date = new Date(key.event.added);

            key.extract.forEach((key, val) => {
                console.log(key, val);
                extract.push(
                    '<figure class="col-12 col-md-2">' +
                    '<img src="' + key.url + '" alt="' + key.alt + '" class="img-fluid">' +
                    '</figure>'
                );
            });
            items.push(
                '<article class="dce-bg-dark dce-text-light d-flex">' +
                ' <div class="article-tumbnail col-md-4">' +
                '<img src="' + key.event.image.url + '" alt="' + key.event.image.alt + '"' +
                '                                         class="img-fluid img-responsive"/>' +
                '</div>' +
                '<div class="article-content d-flex flex-column col-md-8">\n' +
                '   <div class="article-header text-center mb-2">\n' +
                '       <h3>' + key.event.title + '</h3>' +
                '<p class="article-date">Date: ' + date.toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) + '</p>' +
                '<p class="article-date">Lieu: ' + key.event.place.name + ' ' + key.event.place.address + '</p>' +
                '</div>' +
                '<div class="grid galerie">' +
                extract +
                '</div>' +
                '<div class="d-flex mx-auto">' +
                '  <a href="/galerie/' + key.event.slug + '" class="dce-btn dce-btn-red">Voir la galerie</a>' +
                '</div></div></article>'
            )
        });

        this.e.html(items);
        $(".galerie img").each(function () {
            $(this).height(this.width);
        });
    }
}