import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ["price", "selectedService"]

    connect() {
        this.updatePrice()
    }

    updatePrice() {
        this.priceTarget.innerText = new Intl.NumberFormat(
            'en-US',
            {style: 'currency', currency: 'USD'}
        ).format(
            this.selectedServiceTarget.selectedOptions[0].dataset.price / 100,
        );
    }
}
