export default class Home {

    constructor() {
        this.post = $(".featured-post");
        this.services = $(".prestation");
        this.setBackgrounds();
    }

    setBackgrounds() {

        $(this.services).each((key , value) => {
            let bg = $(value).data('bg');
            $(value).children('.prestation-text').css('background', 'linear-gradient(rgba(0, 0, 0, .6), rgba(0, 0, 0, .6)), url(' + bg + ') no-repeat center');
            $(value).children('.prestation-text').css('background-size', 'cover');
        });

        let postImg = $(this.post ).children('.section-img');

        postImg.css('background', 'url(' + postImg.data('bg') + ') no-repeat center');
        postImg.css('background-size', 'cover');
    }
}