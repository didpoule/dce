import Component from "../Component";

export default class Booking extends Component {

    constructor(e) {
        super(e);

        this.validate();

        this.messages = {
            'invalid': {
                'name': 'Votre nom doit comporter entre 3 et 50 caractères.',
                'firstname': 'Votre prénom doit comporter entre 3 et 50 caractères.',
                'day': 'Ce jour est invalide.',
                'month': 'Ce mois est invalide',
                'year': 'Cette année est invalide.',
                'address': 'Votre adresse doit comporter 5 et 100 caractères minimum.',
                'zipcode': 'Votre code postal doit être numérique et comporter 5 chiffres.',
                'city': 'Votre ville doit comporter entre 3 et 50 caractères.',
                'country': 'Nom de pays incorrect',
                'phone': 'Votre numéro de téléphone doit comporter entre 3 et 12 caractères',
                'email': "L'adresse email doit être au format nom@domaine.extension",
                'formula': 'Formule incorrecte.'
            },
        };
    }

    validate() {

        $('#booking_name').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 3) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_firstname').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 3) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_birthday_day').focusout((e) => {
            let $this = $(e.currentTarget);
            let val = parseInt($this.val());
            (isNaN(val) || (val < 1 || val > 31))
                ? this.setColor($this, false)
                : this.setColor($this)
            ;

        });

        $('#booking_birthday_month').focusout((e) => {
            let $this = $(e.currentTarget);
            let val = parseInt($this.val());
            (isNaN(val) || (val < 1 || val > 12))
                ? this.setColor($this, false)
                : this.setColor($this)
            ;

        });

        $('#booking_birthday_year').focusout((e) => {
            let $this = $(e.currentTarget);
            let val = parseInt($this.val());
            (isNaN(val) || val > (new Date().getFullYear()))
                ? this.setColor($this, false)
                : this.setColor($this)
            ;

        });

        $('#booking_address').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 10) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_zipcode').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 5 && !Number.isInteger($this.val())) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_city').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 3) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_country').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length != 2) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_phone').focusout((e) => {
            let $this = $(e.currentTarget);
            ($this.val().length < 3) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_formula').focusout((e) => {
            let $this = $(e.currentTarget);
            let val = parseInt($this.val());

            (isNaN(val)) ? this.setColor($this, false) : this.setColor($this);
        });

        $('#booking_email').focusout((e) => {
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