export default class Home {

    constructor() {
        this.post = $(".featured-post");
        this.services = $(".prestation");
        this.setBackgrounds();
    }

    setBackgrounds() {

        $(this.services).each((key, value) => {
            let bg = $(value).data('bg');
            $(value).children('.prestation-text').children('.background-image').css('background', 'linear-gradient(rgba(0, 0, 0, .6), rgba(0, 0, 0, .6)), url(' + bg + ') no-repeat center');
            $(value).children('.prestation-text').children('.background-image').css('background-size', 'cover');
        });

        let eventImg = $(this.event).children('.section-img');

        let postImg = $(this.post).children('.section-img');

    }
}