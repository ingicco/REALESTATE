// Simple, bulletproof scroll animations
document.addEventListener('DOMContentLoaded', function() {
    // Add animation classes to elements
    const elements = [
        { selector: '.value-card', animation: 'animate-up' },
        { selector: '.services-column', animation: 'animate-up' },
        { selector: '.testimonial-content', animation: 'animate-up' },
        { selector: '.contact-form-container', animation: 'animate-left' },
        { selector: '.contact-assurance', animation: 'animate-right' },
        { selector: '.slider-content', animation: 'animate-left' },
        { selector: '.slider-images', animation: 'animate-right' },
        { selector: '.services-sidebar', animation: 'animate-right' },
        { selector: '.benefits-cta', animation: 'animate-up' }
    ];
    
    // Apply animation classes
    elements.forEach(item => {
        document.querySelectorAll(item.selector).forEach(el => {
            el.classList.add(item.animation);
        });
    });
    
    // Observe elements
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                entry.target.classList.remove('visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px'
    });
    
    // Observe all animated elements
    document.querySelectorAll('.animate-up, .animate-left, .animate-right').forEach(el => {
        observer.observe(el);
    });
});

