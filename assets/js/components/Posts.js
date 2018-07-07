import Component from "../Component";

export default class Posts extends Component {

    constructor() {
        super($("#list-posts"));
        this.datas = ($("#posts-datas"));
        this.pages = $(".posts-page");
        this.url = this.datas.data('url');
        this.count = this.datas.data('count');
        this.limit = 5;
        this.current = 0;

        this.nbPages = Math.ceil(this.count / this.limit);

        this.attachEvents();

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
        $(".posts-next a").on('click', () => this.next((this)));
        $(".posts-prev a").on('click', () => this.previous((this)));

        let $this = this;
        this.pages.on('click',  function() {
            $this.goTo($this, $(this).data('page'));
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
                '                                         class="img-fluid img-responsive"/>' +
                '</div>' +
                '<div class="article-content d-flex flex-column col-md-6">' +
                ' <h3>' + key.title + '</h3>' +
                '<p class="article-date">Publié le: ' + date.toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) + '</p>' +
                '<p class="article-text">' +
                key.content +
                '</p>' +
                '<div class="d-flex mx-auto">' +
                '  <a href="/news/' + key.slug + '" class="dce-btn dce-btn-red">Tout lire</a>' +
                '</div></div></div></article>'
            )
        });

        this.e.html(items);
    }
}