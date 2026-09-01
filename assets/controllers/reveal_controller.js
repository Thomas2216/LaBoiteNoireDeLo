import { Controller } from '@hotwired/stimulus';

/*
 * Fades + slides an element in the first time it enters the viewport.
 * Usage: add class="reveal" data-controller="reveal" to the element.
 * Optional stagger: data-reveal-delay-value="80" (milliseconds).
 */
export default class extends Controller {
    static values = { delay: { type: Number, default: 0 } };

    connect() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.element.classList.add('is-visible');
            return;
        }

        if (this.delayValue) {
            this.element.style.transitionDelay = `${this.delayValue}ms`;
        }

        this.observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    this.observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

        this.observer.observe(this.element);
    }

    disconnect() {
        this.observer?.disconnect();
    }
}
