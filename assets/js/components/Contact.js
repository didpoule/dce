import Component from "../Component";

export default class Contact extends Component {

    constructor(e) {
        super(e);

        this.validator = {};
        this.getValidator();

        this.messages = {
            'invalid': {},
        };

        this.constraints = {};
    }

    getValidator() {

        return $.ajax({
            url: 'http://localhost:8000/validator_ajax/contact'
        }).done((datas) => {
            let validator = JSON.parse(datas);
            $.each(validator.properties, (property, params) => {
                this.validator[property] = params.constraints[0];

                this.setMessage(property, params.constraints[0]);
                this.setConstraint(property, params.constraints[0]);

                this.validate(property);

            });

        });
    }

    setConstraint(property, params) {
        if ('min' in params) {
            this.constraints[property] = {
                'min': params.min,
                'max': params.max
            };
        } else if ('pattern' in params) {

            this.constraints[property] = {
                'regex': /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

            };
        }
    }

    setMessage(property, params) {

        let frenchNames = {
            'name': 'nom',
            'firstname': 'prénom',
            'phone': 'numéro de téléphone',
            'email': 'email',
        };

        let message = 'Votre ';

        if ('min' in params) {
            message += frenchNames[property] + ' doit comporter entre ' + params.min + ' et ' + params.max + ' caractères.';
            this.messages['invalid'][property] = message;

        } else if ('pattern' in params) {
            message += frenchNames[property] + ' doit être au format "nom@domaine.ext"';
            this.messages['invalid'][property] = message;

        }
    }

    validate(property) {
        $("#contact_" + property).focusout((e) => {
            let el = $(e.currentTarget);
            let constraints = this.constraints[property];

            if ('min' in constraints) {
                (el.val().length < constraints.min || el.val().length > constraints.max) ? this.toggleMessage(el, false) : this.toggleMessage(el);
            } else if ('regex' in constraints) {
                (!el.val().match(constraints.regex)) ? this.toggleMessage(el, false) : this.toggleMessage(el);
            }
        })

    }

    toggleMessage(element, success = true) {
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