import Component from "../Component";

export default class Formulas extends Component {

    constructor(e) {
        super(e);
        this.addBtn = $('<button type="button" class="add_tag_link btn btn-sm btn-primary col-md-2 col-12 offset-md-5">Ajouter</button>');
        this.newLink = $('<div></div>');
        this.newLink.append(this.addBtn);
        this.e.append(this.newLink);
        this.formulas = $(".event-formula");
        this.newLink.before(this.formulas.last());


        this.e.data('index', this.e.find(':input').length);
        this.addBtn.on('click', (e) => {
            this.addFormula(this.e, this.newLink);
        });

        this.formulas.each((index, element) => {
            this.addDeleteLink($(element));
        });


    }

    addDeleteLink(element) {
        let removeBtn = $('<button type="button" class="remove_tag_link btn btn-sm btn-danger col-md-2 col-12 offset-md-5">Supprimer</button>');

        element.append(removeBtn);

        removeBtn.on('click', (e) => {
            element.remove();
        })
    }

    addFormula(e, newLink) {

        let prototype = e.data('prototype');

        let index = e.data('index');

        let newForm = prototype;

        newForm = newForm.replace(/__name__/g, index);

        e.data('index', index + 1);

        let newFormDiv = $('<div class="form-group"></div>').append(newForm);


        newLink.before(newFormDiv);

        this.addDeleteLink(newFormDiv);
    }
}