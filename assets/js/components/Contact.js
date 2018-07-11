import Component from "../Component";

export default class Contact extends Component {

    constructor(e) {
        super(e);

        this.validate();

        this.messages = {
            'invalid': {
                'name': 'Votre nom doit comporter entre 3 et 50 caractères.',
                'firstname': 'Votre prénom doit comporter entre 3 et 50 caractères.',
                'subject': 'Le sujet doit comporter entre 5 et 100 caractères',
                'content': 'Votre message doit comporter ente 5 et 500 caractères.',
                'email': "L'adresse email doit être au format nom@domaine.extension",
            },
        };
    }

    validate() {

        $('#contact_name').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 3) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#contact_firstname').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 3) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#contact_subject').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 5) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#contact_content').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 5) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#contact_email').focusout((e) => {
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            let $this = $(e.currentTarget);
            (!$this.val().match(re)) ? this.setColor($this, false) : this.setColor($this);
        });

    }

    setColor(element, success = true) {
        let property = this.getPropertyName(element);

        if (success) {
            element.toggleClass('bg-danger', false);
            element.toggleClass('bg-success', true);
            if (element.parent().children(".error-message").length > 0) {
                element.parent().children(".error-message").toggle(false);
            }
        } else {
            let message = $("<div class='error-message text-danger'>" +
                this.messages.invalid[property] +
                "</div>");

            if (element.parent().children(".error-message").length === 0) {
                element.parent().append(message);
            } else {
                element.parent().children(".error-message").toggle(true);
            }

            element.toggleClass('bg-danger', true);
            element.toggleClass('bg-success', false);
        }
    }

    getPropertyName(element) {
        let splittedId = element.attr('id').split('_');
        return splittedId[splittedId.length - 1];

    }

}