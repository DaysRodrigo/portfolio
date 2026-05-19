import './bootstrap';

import Alpine from 'alpinejs';
import 'preline';

window.Alpine = Alpine;

Alpine.data('projectCarousel', () => ({
    open: false,
    project: null,
    slide: 0,
    openProject(p) { this.project = p; this.slide = 0; this.open = true; },
    prev() { if (this.slide > 0) this.slide--; },
    next() { if (this.project && this.slide < this.project.images.length - 1) this.slide++; },
}));

Alpine.start();
