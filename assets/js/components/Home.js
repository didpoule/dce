export default class Home {

    constructor() {
        this.event = $(".featured-event");
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

        eventImg.css('background', 'url(' + eventImg.data('bg') + ') no-repeat center');
        eventImg.css('background-size', 'contain');
        this.event.css('height', eventImg.children('img').height());

        let postImg = $(this.post).children('.section-img');

        postImg.css('background', 'url(' + postImg.data('bg') + ') no-repeat center');
        postImg.css('background-size', 'cover');
    }
}