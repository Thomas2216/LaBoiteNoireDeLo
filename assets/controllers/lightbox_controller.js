import { Controller } from '@hotwired/stimulus';
import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';

/*
 * Opens the portfolio grid photos in a fullscreen lightbox. Grouping (and
 * therefore prev/next navigation) is scoped per category via each trigger's
 * data-gallery attribute, set in home/portfolio.html.twig.
 */
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        this.lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: false,
            zoomable: true,
            closeButton: true,
        });
    }

    disconnect() {
        this.lightbox?.destroy();
    }
}
