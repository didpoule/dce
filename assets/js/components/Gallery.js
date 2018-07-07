import Component from "../Component";

export default class Gallery extends Component {

    constructor() {
        super($("#galerie"));
        this.datas = $("#gallery-datas");
        this.url = this.datas.data('url');

        this.count = this.datas.data('count');
        this.limit = 12;
        this.current = 0;

        this.nbPages = Math.ceil(this.count / this.limit);

        this.attachEvents();

        console.log(this.nbPages);

    }

    next(that) {
        let $this = that;

        if (($this.current + 1) < $this.nbPages) {
            $this.current++;

            $.ajax({
                url: $this.url + '/' + $this.current
            }).done(function (datas) {
                let pictures = JSON.parse(datas);
                $this.updateContent(pictures);
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
                let pictures = JSON.parse(datas);
                $this.updateContent(pictures);
            })
        }
    }

    attachEvents() {
        $(".galerie-next i").on('click', () => this.next(this));
        $(".galerie-prev i").on('click', () => this.previous(this));
    }

    updateContent(datas) {
        let items = [];

        datas.forEach((key, val) => {
            items.push(
                '<li class="col-md-2"><a href="' + key.url + '" data-lightbox="roadtrip">' +
                '<img src="' + key.url + '" alt="' + key.alt + '" class="img-fluid galerie-img">' +
                '</a>' +
                '</li'
            )
        });

        this.e.html(items);

        $(".galerie img").each(function () {
            $(this).height(this.width);
        });
    }
}