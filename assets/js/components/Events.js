import Component from "../Component";

export default class Galleries extends Component {

    constructor() {
        super($("#list-events"));
        this.datas = ($("#events-datas"));
        this.url = this.datas.data('url');
        this.pages = $(".events-page");

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
        $(".events-next a").on('click', () => this.next((this)));
        $(".events-prev a").on('click', () => this.previous((this)));

        let $this = this;
        this.pages.on('click',  (e) => {
            $this.goTo($this, $(e.currentTarget).data('page'));
        })
    }

    updateContent(datas) {
        let items = [];

        datas.forEach((key, val) => {

            let date = new Date(key.added);

            items.push(
                '<article class="dce-bg-dark dce-text-light d-flex">' +
                ' <div class="article-tumbnail col-md-6">' +
                '<img src="' + key.image.url + '" alt="' + key.image.alt + '"' +
                '                                         class="img-fluid"/>' +
                '</div>' +
                '<div class="article-content d-flex flex-column col-md-6">\n' +
                '       <h3>' + key.title + '</h3>' +
                '<p class="article-date">Date: ' + date.toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) + '</p>' +
                '<p class="article-date">Lieu: ' + key.place.name + ' ' + key.place.address + '</p>' +
                '<p>' +
                key.content +
                '</p>' +
                '<div class="d-flex mx-auto">' +
                '  <a href="/workshop/' + key.slug + '" class="dce-btn dce-btn-red">Plus d\'infos</a>' +
                '</div></div></article>'
            )
        });

        this.e.html(items);
    }
}