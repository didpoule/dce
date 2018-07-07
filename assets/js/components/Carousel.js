import Component from "../Component";

/**
 * Carousel class
 */
export default class Carousel extends Component {

    datas = [];
    current;

    constructor(e, datas) {
        super(e);
        this.current = 1;
        this.datas = datas;
    }
}