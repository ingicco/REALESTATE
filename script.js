// ===== SOPHISTICATED WEBSITE FUNCTIONALITY =====

document.addEventListener('DOMContentLoaded', function() {
    // Initialize core functionality
    initSmoothScrolling();
    initSmoothScrollingLinks();
    initMobileNavigation();
    initContactForm();
    initFloatingContact();
    initScrollAnimations();
    initNavigationObserver();
    initValueModals();
    initLuxurySlider();
    initFAQ();
    initPrivacyModal();
});

// Smooth Scrolling Navigation
function initSmoothScrolling() {
    // Handle all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);
            
            if (targetSection) {
                const offsetTop = targetSection.offsetTop;
                const isMobile = window.innerWidth <= 768;
                const offset = isMobile ? 20 : 80;
                
                window.scrollTo({
                    top: offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Handle hero buttons
    const heroButtons = document.querySelectorAll('.hero-buttons .btn');
    heroButtons.forEach((btn, index) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (index === 0) {
                // Schedule consultation - scroll to contact
                scrollToSection('contact');
            } else {
                // View approach - scroll to services
                scrollToSection('services');
            }
        });
    });
}

// Mobile Navigation Management
function initMobileNavigation() {
    const mobileNav = document.getElementById('mobileNav');
    const navItems = mobileNav.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get target section
            const targetId = this.getAttribute('href').substring(1);
            scrollToSection(targetId);
        });
    });
}

// Contact Form Handling
function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleContactSubmission(this);
        });
    }
}

function handleContactSubmission(form) {
    const formData = new FormData(form);
    const name = form.querySelector('input[type="text"]').value;
    const email = form.querySelector('input[type="email"]').value;
    const phone = form.querySelector('input[type="tel"]').value;
    const investment = form.querySelector('select').value;
    const message = form.querySelector('textarea').value;
    
    // Basic validation
    if (!name.trim() || !email.trim()) {
        showNotification('Please provide your name and email address.', 'error');
        return;
    }
    
    if (!isValidEmail(email)) {
        showNotification('Please enter a valid email address.', 'error');
        return;
    }
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.querySelector('span').textContent;
    submitBtn.querySelector('span').textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Simulate form submission (replace with actual endpoint)
    setTimeout(() => {
        // Reset button
        submitBtn.querySelector('span').textContent = originalText;
        submitBtn.disabled = false;
        
        // Clear form
        form.reset();
        
        // Show success message
        showNotification(`Thank you, ${name}. We will contact you within 24 hours to schedule your consultation.`, 'success');
        
        // In production, send to your CRM/email service
        console.log('Contact form submitted:', {
            name, email, phone, investment, message,
            timestamp: new Date().toISOString()
        });
    }, 2000);
}

// Floating Contact Button
function initFloatingContact() {
    const floatingContact = document.getElementById('floatingContact');
    
    if (floatingContact) {
        floatingContact.addEventListener('click', function() {
            scrollToSection('contact');
        });
    }
}

// Enhanced Scroll Animations with Continuous Effects
function initScrollAnimations() {
    console.log('Initializing enhanced continuous scroll animations');
    
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -80px 0px'
    };
    
    // Continuous animation observer - animates both ways
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add animated class when element enters viewport
                entry.target.classList.add('animated');
                console.log('Animating element:', entry.target.classList);
            } else {
                // Remove animated class when element leaves viewport
                // This makes the animation trigger again when scrolling back
                entry.target.classList.remove('animated');
            }
        });
    }, observerOptions);
    
    // Animate different element types with different effects
    
    // Fade in from bottom - for cards and content blocks
    const fadeUpElements = document.querySelectorAll(`
        .value-card,
        .services-column,
        .service-text,
        .faq-item,
        .contact-form-container,
        .contact-assurance,
        .testimonial-content,
        .benefits-cta
    `);
    console.log(`Found ${fadeUpElements.length} fade-up elements (including ${document.querySelectorAll('.value-card').length} value cards)`);
    fadeUpElements.forEach((el, index) => {
        el.classList.add('fade-in-up');
        if (index > 0 && index < 6) {
            el.classList.add(`stagger-${index}`);
        }
        observer.observe(el);
    });
    
    // Fade in from left - for text content (excluding hero)
    const fadeLeftElements = document.querySelectorAll(`
        .slider-content,
        .services-header,
        .faq-header,
        .contact-header
    `);
    fadeLeftElements.forEach(el => {
        el.classList.add('fade-in-left', 'dramatic-animation');
        observer.observe(el);
    });
    
    // Fade in from right - for images (excluding hero)
    const fadeRightElements = document.querySelectorAll(`
        .slider-images,
        .services-sidebar,
        .mobile-sidebar
    `);
    fadeRightElements.forEach(el => {
        el.classList.add('fade-in-right', 'dramatic-animation');
        observer.observe(el);
    });
    
    // Scale in - for special elements
    const scaleElements = document.querySelectorAll(`
        .mobile-service-item img,
        .services-column img,
        .image-item img
    `);
    scaleElements.forEach((el, index) => {
        el.classList.add('scale-in');
        if (index < 6) {
            el.classList.add(`stagger-${(index % 3) + 1}`);
        }
        observer.observe(el);
    });
    
    // Parallax effect on scroll
    initParallaxEffect();
    
    console.log(`Observing ${fadeUpElements.length + fadeLeftElements.length + fadeRightElements.length + scaleElements.length} elements for animation`);
}

// Parallax scrolling effect for images
function initParallaxEffect() {
    const parallaxElements = document.querySelectorAll('.slider-images img, .hero-images img');
    
    if (parallaxElements.length === 0) return;
    
    let ticking = false;
    
    function updateParallax() {
        parallaxElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            const scrolled = window.pageYOffset;
            const rate = rect.top * 0.05; // Adjust this for more/less parallax
            
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                el.style.transform = `translateY(${rate}px) scale(1.05)`;
            }
        });
        ticking = false;
    }
    
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(updateParallax);
            ticking = true;
        }
    });
}

// Navigation Observer for Active States
function initNavigationObserver() {
    const sections = document.querySelectorAll('section[id]');
    const navItems = document.querySelectorAll('.mobile-nav .nav-item');
    
    const observerOptions = {
        threshold: 0.3,
        rootMargin: '-20% 0px -20% 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const sectionId = entry.target.id;
                
                // Update mobile nav active state
                navItems.forEach(item => {
                    item.classList.remove('active');
                    const itemHref = item.getAttribute('href').substring(1);
                    if (itemHref === sectionId) {
                        item.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);
    
    sections.forEach(section => observer.observe(section));
}

// Utility Functions
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        const offsetTop = section.offsetTop;
        const isMobile = window.innerWidth <= 768;
        const offset = isMobile ? 20 : 80;
        
        window.scrollTo({
            top: offsetTop - offset,
            behavior: 'smooth'
        });
    }
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Sophisticated Notification System
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    const colors = {
        success: '#2D5A27',
        error: '#8B2635',
        info: '#1a1a1a'
    };
    
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add sophisticated styles
    notification.style.cssText = `
        position: fixed;
        top: 30px;
        right: 30px;
        background: ${colors[type]};
        color: white;
        padding: 1.5rem 2rem;
        border-radius: 0;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        z-index: 10000;
        max-width: 400px;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        line-height: 1.5;
        animation: slideInRight 0.4s ease-out;
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Handle close button
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.animation = 'slideOutRight 0.4s ease-out';
        setTimeout(() => notification.remove(), 400);
    });
    
    // Auto remove after 6 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.4s ease-out';
            setTimeout(() => notification.remove(), 400);
        }
    }, 6000);
}

// Performance Optimizations
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle window resize for responsive adjustments
window.addEventListener('resize', debounce(() => {
    const isMobile = window.innerWidth <= 768;
    
    // Update body padding for mobile nav
    if (isMobile) {
        document.body.style.paddingBottom = '80px';
    } else {
        document.body.style.paddingBottom = '0';
    }
}, 250));

// Add sophisticated CSS animations
const animationStyles = document.createElement('style');
animationStyles.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification-content {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }
    
    .notification-close:hover {
        opacity: 1;
    }
`;
document.head.appendChild(animationStyles);

// Initialize lazy loading for images (performance optimization)
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });
        
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    }
}

// Call lazy loading initialization
initLazyLoading();

// Sophisticated scroll behavior for hero video
function initHeroVideoEffects() {
    const heroVideo = document.querySelector('.hero-video');
    const heroOverlay = document.querySelector('.hero-overlay');
    
    if (heroVideo && heroOverlay) {
        window.addEventListener('scroll', debounce(() => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            
            // Parallax effect
            heroVideo.style.transform = `translateY(${rate}px)`;
            
            // Overlay opacity change
            const opacity = Math.min(0.4 + (scrolled / 1000), 0.8);
            heroOverlay.style.background = `rgba(26, 26, 26, ${opacity})`;
        }, 10));
    }
}

// Initialize hero effects
initHeroImageEffects();

// Testimonial Carousel Functionality
function initTestimonialCarousel() {
    const carousel = document.getElementById('testimonialCarousel');
    if (!carousel) return;
    
    const slides = carousel.querySelectorAll('.testimonial-slide');
    const indicators = document.querySelectorAll('.testimonial-indicators .indicator');
    
    let currentSlide = 0;
    let autoPlayInterval;
    
    // Auto-play functionality
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextSlide();
        }, 4000); // Change slide every 4 seconds
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }
    
    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        // Show current slide
        slides[index].classList.add('active');
        if (indicators[index]) {
            indicators[index].classList.add('active');
        }
        
        currentSlide = index;
    }
    
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
    }
    
    function prevSlide() {
        const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prevIndex);
    }
    
    // Indicator click handlers
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopAutoPlay();
            showSlide(index);
            setTimeout(startAutoPlay, 2000); // Restart auto-play after 2 seconds
        });
    });
    
    // Pause on hover
    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);
    
    // Touch/swipe support for mobile
    let startX = 0;
    let endX = 0;
    
    carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        stopAutoPlay();
    });
    
    carousel.addEventListener('touchend', (e) => {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
        setTimeout(startAutoPlay, 2000);
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
    }
    
    // Start auto-play
    startAutoPlay();
}

// FAQ Functionality
function initFAQ() {
    const faqItems = document.querySelectorAll('.faq-item');
    console.log('FAQ items found:', faqItems.length); // Debug log
    
    faqItems.forEach((item, index) => {
        const question = item.querySelector('.faq-question');
        const toggle = item.querySelector('.faq-toggle');
        
        if (question) {
            console.log(`Setting up FAQ item ${index + 1}`); // Debug log
            
            question.addEventListener('click', (e) => {
                e.preventDefault();
                console.log(`FAQ item ${index + 1} clicked`); // Debug log
                
                // Close all other FAQ items
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        const otherToggle = otherItem.querySelector('.faq-toggle');
                        if (otherToggle) {
                            otherToggle.textContent = '+';
                        }
                    }
                });
                
                // Toggle current item
                const isActive = item.classList.contains('active');
                if (isActive) {
                    item.classList.remove('active');
                    if (toggle) toggle.textContent = '+';
                } else {
                    item.classList.add('active');
                    if (toggle) toggle.textContent = '−';
                }
            });
        }
    });
}

// Enhanced hero image effects (replacing video effects)
function initHeroImageEffects() {
    const heroImage = document.querySelector('.hero-image');
    const heroOverlay = document.querySelector('.hero-overlay');
    
    if (heroImage && heroOverlay) {
        window.addEventListener('scroll', debounce(() => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.3;
            
            // Parallax effect
            heroImage.style.transform = `translateY(${rate}px) scale(1.05)`;
            
            // Overlay opacity change
            const opacity = Math.min(0.3 + (scrolled / 1000), 0.7);
            heroOverlay.style.background = `rgba(26, 26, 26, ${opacity})`;
        }, 10));
    }
}

// Expandable Value Cards Functionality
function initExpandableValueCards() {
    const valueCards = document.querySelectorAll('.value-card');
    
    valueCards.forEach(card => {
        card.addEventListener('click', function() {
            const isExpanded = this.classList.contains('expanded');
            
            // Close all other cards
            valueCards.forEach(otherCard => {
                otherCard.classList.remove('expanded');
            });
            
            // Toggle current card
            if (!isExpanded) {
                this.classList.add('expanded');
                
                // Smooth scroll to the expanded card
                setTimeout(() => {
                    this.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }, 300);
            }
        });
        
        // Add hover effect for better UX
        card.addEventListener('mouseenter', function() {
            if (!this.classList.contains('expanded')) {
                this.style.cursor = 'pointer';
            }
        });
    });
    
    // Close expanded card when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.value-card')) {
            valueCards.forEach(card => {
                card.classList.remove('expanded');
            });
        }
    });
}

// Value Modals Functionality
function initValueModals() {
    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('valueModal');
        if (event.target === modal) {
            closeValueModal();
        }
    };
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeValueModal();
        }
    });
}

function openValueModal(cardNumber) {
    console.log('Opening modal for card:', cardNumber); // Debug log
    const modal = document.getElementById('valueModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    
    if (!modal || !modalTitle || !modalContent) {
        console.error('Modal elements not found');
        return;
    }
    
    const valueData = {
        investment: {
            title: "Asset Management Excellence",
            content: `
                <div class="modal-intro">
                    Professional property management and optimization services designed to maximize returns, maintain asset value, and ensure seamless operations across your UAE real estate portfolio.
                </div>
                
                <ul class="modal-benefits">
                    <li>Comprehensive tenant screening, placement, and relationship management</li>
                    <li>Property maintenance coordination and quality control oversight</li>
                    <li>Financial reporting with transparent accounting and tax documentation</li>
                    <li>Strategic value enhancement and repositioning recommendations</li>
                    <li>Rental optimization and market positioning analysis</li>
                    <li>Managing <svg class="dirham-symbol" viewBox="0 0 345 300"><path d="M342 141l3 3v-8c0-17-12-31-27-31h-23C279 37 223 0 140 0H30s15 13 15 52v53H18c-5 0-10-2-15-6l-3-3v8c0 17 12 31 27 31h18v30H18c-5 0-10-2-15-6l-3-3v8c0 17 12 31 27 31h18v55c0 39-15 50-15 50h110c86 0 140-37 155-105h32c5 0 10 2 15 6l3 3v-8c0-17-12-31-27-31h-19c0-5 0-10 0-15s0-10-1-15h28c5 0 10 2 15 6zM90 15h46c62 0 97 27 108 90H90V15zm46 270H90v-90h154c-10 57-42 88-108 90zm111-135c0 5 0 10 0 15H90v-30h157c0 5 0 10 0 15z"/></svg>2B+ in UAE property assets under management</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Ready to Maximize Your Asset Performance?</h4>
                    <p>Schedule a confidential consultation with our specialists</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Secure Your Investment Strategy</a>
                </div>
            `
        },
        tax: {
            title: "Off-Market Opportunities",
            content: `
                <div class="modal-intro">
                    Gain exclusive access to premium Dubai properties before they reach the public market, giving you first-mover advantage on the city's most coveted real estate investments.
                </div>
                
                <ul class="modal-benefits">
                    <li>Pre-launch access to exclusive developer allocations and prime units</li>
                    <li>Private treaty sales from UHNW sellers seeking discreet transactions</li>
                    <li>First look at trophy properties in Palm Jumeirah, Emirates Hills, and Downtown</li>
                    <li>Privileged pricing and terms not available to retail market buyers</li>
                    <li>Curated property selection matching your specific investment criteria</li>
                    <li>Access to <svg class="dirham-symbol" viewBox="0 0 345 300"><path d="M342 141l3 3v-8c0-17-12-31-27-31h-23C279 37 223 0 140 0H30s15 13 15 52v53H18c-5 0-10-2-15-6l-3-3v8c0 17 12 31 27 31h18v30H18c-5 0-10-2-15-6l-3-3v8c0 17 12 31 27 31h18v55c0 39-15 50-15 50h110c86 0 140-37 155-105h32c5 0 10 2 15 6l3 3v-8c0-17-12-31-27-31h-19c0-5 0-10 0-15s0-10-1-15h28c5 0 10 2 15 6zM90 15h46c62 0 97 27 108 90H90V15zm46 270H90v-90h154c-10 57-42 88-108 90zm111-135c0 5 0 10 0 15H90v-30h157c0 5 0 10 0 15z"/></svg>500M+ in off-market inventory annually</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Ready to Access Exclusive Opportunities?</h4>
                    <p>Connect with our off-market specialists for confidential listings</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">View Private Inventory</a>
                </div>
            `
        },
        portfolio: {
            title: "Portfolio Strategy Integration",
            content: `
                <div class="modal-intro">
                    Integrate UAE properties seamlessly into your global portfolio with institutional-grade analysis and strategic asset allocation expertise.
                </div>
                
                <ul class="modal-benefits">
                    <li>Strategic asset allocation analysis within your global portfolio</li>
                    <li>Currency hedging and foreign exchange risk management</li>
                    <li>Correlation analysis with your existing real estate holdings</li>
                    <li>Risk-adjusted return optimization and diversification benefits</li>
                    <li>Integration with your family office and wealth management team</li>
                    <li>Enhanced portfolio returns: <svg class="dirham-symbol" viewBox="0 0 345 300"><path d="M342 141l3 3v-8c0-17-12-31-27-31h-23C279 37 223 0 140 0H30s15 13 15 52v53H18c-5 0-10-2-15-6l-3-3v8c0 17 12 31 27 31h18v30H18c-5 0-10-2-15-6l-3-3v8c0 17 12 31 27 31h18v55c0 39-15 50-15 50h110c86 0 140-37 155-105h32c5 0 10 2 15 6l3 3v-8c0-17-12-31-27-31h-19c0-5 0-10 0-15s0-10-1-15h28c5 0 10 2 15 6zM90 15h46c62 0 97 27 108 90H90V15zm46 270H90v-90h154c-10 57-42 88-108 90zm111-135c0 5 0 10 0 15H90v-30h157c0 5 0 10 0 15z"/></svg>12.3% average annual returns</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Ready to Optimize Your Portfolio Strategy?</h4>
                    <p>Discover how UAE real estate can enhance your global investments</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Maximize Portfolio Growth</a>
                </div>
            `
        },
        // Aliases for specialty cards
        'asset-management': {
            title: "Asset Management Excellence",
            content: `
                <div class="modal-intro">
                    Institutional-grade property oversight delivering superior returns through active management, strategic positioning, and operational excellence across your UAE real estate portfolio.
                </div>
                
                <ul class="modal-benefits">
                    <li>Comprehensive tenant screening, placement, and relationship management</li>
                    <li>Property maintenance coordination and quality control oversight</li>
                    <li>Financial reporting with transparent accounting and tax documentation</li>
                    <li>Strategic value enhancement and repositioning recommendations</li>
                    <li>Rental optimization and market positioning analysis</li>
                    <li>Managing AED 2B+ in UAE property assets under management</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Interested in Our Asset Management Services?</h4>
                    <p>Submit your application for review by our partners</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Apply Now</a>
                </div>
            `
        },
        'off-market': {
            title: "Off-Market Opportunities",
            content: `
                <div class="modal-intro">
                    Privileged access to Dubai's most exclusive properties before public listing, secured through our established developer relationships and UHNW seller network.
                </div>
                
                <ul class="modal-benefits">
                    <li>Pre-launch access to exclusive developer allocations and prime units</li>
                    <li>Private treaty sales from UHNW sellers seeking discreet transactions</li>
                    <li>First look at trophy properties in Palm Jumeirah, Emirates Hills, and Downtown</li>
                    <li>Privileged pricing and terms not available to retail market buyers</li>
                    <li>Curated property selection matching your specific investment criteria</li>
                    <li>Access to AED 500M+ in off-market inventory annually</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Request Access to Off-Market Listings</h4>
                    <p>Submit your application to view our exclusive inventory</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Apply Now</a>
                </div>
            `
        },
        'intelligence': {
            title: "Market Intelligence & Research",
            content: `
                <div class="modal-intro">
                    Proprietary research, institutional-grade data analytics, and market timing intelligence unavailable through public channels or retail advisory firms.
                </div>
                
                <ul class="modal-benefits">
                    <li>Exclusive access to pre-market transaction data and developer pipeline information</li>
                    <li>Proprietary pricing models and neighborhood-level market analysis</li>
                    <li>Macro-economic research tailored to UAE real estate implications</li>
                    <li>Investment timing optimization through predictive market analytics</li>
                    <li>Competitive intelligence on institutional buyer and developer activity</li>
                    <li>Weekly market intelligence reports delivered to select clients</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Access Our Market Intelligence</h4>
                    <p>Apply for access to our proprietary research platform</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Apply Now</a>
                </div>
            `
        },
        'liquidity': {
            title: "Liquidity & Exit Planning",
            content: `
                <div class="modal-intro">
                    Strategic exit planning ensuring optimal disposal timing, institutional buyer access, and tax-efficient transaction structuring for maximum net proceeds.
                </div>
                
                <ul class="modal-benefits">
                    <li>Institutional buyer network for expedited, off-market disposals</li>
                    <li>Market timing optimization for disposal execution</li>
                    <li>Tax-efficient exit structuring with international tax coordination</li>
                    <li>Confidential marketing to qualified UHNW and institutional buyers</li>
                    <li>1031 exchange and like-kind exchange structuring expertise</li>
                    <li>Average exit premium of 8-12% above market comparables</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Plan Your Strategic Exit</h4>
                    <p>Discuss your liquidity requirements with our advisors</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Apply Now</a>
                </div>
            `
        },
        'relocation': {
            title: "Relocation & Residency Services",
            content: `
                <div class="modal-intro">
                    White-glove relocation coordination for UHNW families, encompassing residency planning, lifestyle integration, and complete concierge-level support.
                </div>
                
                <ul class="modal-benefits">
                    <li>Golden Visa facilitation and residency planning for investors and families</li>
                    <li>Banking relationship introductions with premier private banking institutions</li>
                    <li>Elite school placement and education advisory services</li>
                    <li>Healthcare concierge and premium medical facility access</li>
                    <li>Lifestyle integration including club memberships and social introductions</li>
                    <li>Ongoing concierge services for seamless UAE lifestyle transition</li>
                </ul>
                
                <div class="modal-cta">
                    <h4>Begin Your UAE Relocation</h4>
                    <p>Apply for our comprehensive relocation services</p>
                    <a href="#contact" class="modal-cta-button" onclick="closeValueModal(); scrollToContact();">Apply Now</a>
                </div>
            `
        }
    };
    
    modalTitle.textContent = valueData[cardNumber].title;
    modalContent.innerHTML = valueData[cardNumber].content;
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeValueModal() {
    console.log('Closing modal'); // Debug log
    const modal = document.getElementById('valueModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Alias for specialty modals (uses same modal system)
function openSpecialtyModal(cardId) {
    openValueModal(cardId);
}

function scrollToContact() {
    setTimeout(() => {
        const contactSection = document.querySelector('.contact-section');
        if (contactSection) {
            contactSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }, 300); // Small delay to allow modal to close first
}

// Privacy Policy Modal Functions
function initPrivacyModal() {
    console.log('Initializing privacy modal'); // Debug log
    
    // Add click event to privacy links
    const privacyLinks = document.querySelectorAll('.privacy-link');
    privacyLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Privacy link clicked'); // Debug log
            openPrivacyModal();
        });
    });
    
    // Add click event to close buttons
    const closeButtons = document.querySelectorAll('#privacyModal .close-modal');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            closePrivacyModal();
        });
    });
    
    // Close modal when clicking outside
    const privacyModal = document.getElementById('privacyModal');
    if (privacyModal) {
        privacyModal.addEventListener('click', function(event) {
            if (event.target === privacyModal) {
                closePrivacyModal();
            }
        });
    }
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('privacyModal');
            if (modal && modal.style.display === 'block') {
                closePrivacyModal();
            }
        }
    });
}

function openPrivacyModal() {
    console.log('Opening privacy modal'); // Debug log
    const modal = document.getElementById('privacyModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        console.log('Privacy modal opened'); // Debug log
    } else {
        console.error('Privacy modal not found'); // Debug log
    }
}

function closePrivacyModal() {
    console.log('Closing privacy modal'); // Debug log
    const modal = document.getElementById('privacyModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        console.log('Privacy modal closed'); // Debug log
    }
}

// Luxury Benefits Slider
function initLuxurySlider() {
    const slideData = [
        {
            title: "Asset Management Excellence",
            description: "<p><strong>The Challenge:</strong> Property owners need professional oversight to maximize returns, maintain asset value, and ensure seamless operations across their UAE portfolio.</p><p><strong>Our Approach:</strong> Institutional-grade property management including tenant relations, maintenance oversight, financial reporting, and strategic value enhancement initiatives.</p>"
        },
        {
            title: "Off-Market Opportunities",
            description: "<p><strong>The Challenge:</strong> The best properties in Dubai sell before reaching public listings, requiring insider access and relationships to secure premium opportunities.</p><p><strong>Our Approach:</strong> Exclusive access to pre-launch developments, private treaty sales, and trophy properties through our network of developers and UHNW sellers.</p>"
        },
        {
            title: "Strategic Portfolio Integration",
            description: "<p><strong>The Challenge:</strong> UAE property must seamlessly integrate with your global investment strategy, risk profile, and wealth preservation objectives while considering currency hedging.</p><p><strong>Our Approach:</strong> Strategic asset allocation analysis ensuring UAE investments enhance your portfolio's risk-adjusted returns and diversification benefits.</p>"
        },
        {
            title: "Market Intelligence & Timing",
            description: "<p><strong>The Challenge:</strong> UAE property markets are driven by global capital flows, policy changes, and economic cycles requiring sophisticated analysis and perfect timing.</p><p><strong>Our Approach:</strong> Institutional-grade research combining macroeconomic analysis, policy intelligence, and exclusive market insights for optimal entry and exit timing.</p>"
        },
        {
            title: "Liquidity & Exit Strategy Excellence",
            description: "<p><strong>The Challenge:</strong> High-net-worth investors need flexible exit strategies that preserve capital, minimize tax implications, and provide multiple liquidity options.</p><p><strong>Our Approach:</strong> Structured exit planning with institutional buyer networks, secondary market access, and tax-optimized disposal strategies.</p>"
        },
        {
            title: "Seamless Relocation & Asset Management",
            description: "<p><strong>The Challenge:</strong> Relocating families require comprehensive support beyond property acquisition, including residency planning, asset management, and lifestyle integration.</p><p><strong>Our Approach:</strong> End-to-end relocation services with institutional-grade asset management, family office integration, and concierge-level lifestyle support.</p>"
        }
    ];

    let currentSlide = 0;
    const totalSlides = slideData.length;

    // Get DOM elements
    const slideTitle = document.querySelector('.slide-title');
    const slideDescription = document.querySelector('.slide-description');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const indicators = document.querySelectorAll('.indicator');
    const imageContainers = document.querySelectorAll('.image-container');

    if (!slideTitle || !slideDescription) {
        console.warn('Luxury slider elements not found');
        return;
    }

    // Initialize slider
    function updateSlider() {
        const data = slideData[currentSlide];
        
        // Update content
        slideTitle.textContent = data.title;
        slideDescription.innerHTML = data.description;

        // Update indicators
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });

        // Update images
        imageContainers.forEach((container, index) => {
            container.classList.toggle('active', index === currentSlide);
        });

        // Update navigation buttons
        if (prevBtn) {
            prevBtn.disabled = currentSlide === 0;
        }
        if (nextBtn) {
            nextBtn.disabled = currentSlide === totalSlides - 1;
        }
    }

    // Navigation functions
    function nextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlider();
        }
    }

    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlider();
        }
    }

    function goToSlide(index) {
        if (index >= 0 && index < totalSlides) {
            currentSlide = index;
            updateSlider();
        }
    }

    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', nextSlide);
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', prevSlide);
    }

    // Indicator clicks
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => goToSlide(index));
    });

    // Auto-advance functionality
    let autoAdvanceInterval;

    function startAutoAdvance() {
        stopAutoAdvance();
        autoAdvanceInterval = setInterval(() => {
            if (currentSlide < totalSlides - 1) {
                nextSlide();
            } else {
                currentSlide = 0;
                updateSlider();
            }
        }, 6000);
    }

    function stopAutoAdvance() {
        if (autoAdvanceInterval) {
            clearInterval(autoAdvanceInterval);
        }
    }

    // Pause auto-advance on hover
    const sliderContainer = document.querySelector('.luxury-slider');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoAdvance);
        sliderContainer.addEventListener('mouseleave', startAutoAdvance);
    }

    // Initialize
    updateSlider();
    startAutoAdvance();

    console.log('Luxury slider initialized successfully');
}

// Toggle card expansion functionality
function toggleCard(cardNumber) {
    const card = document.querySelector(`[data-card="${cardNumber}"]`);
    const allCards = document.querySelectorAll('.value-card');
    
    // Close all other cards
    allCards.forEach(otherCard => {
        if (otherCard !== card) {
            otherCard.classList.remove('expanded');
        }
    });
    
    // Toggle current card
    card.classList.toggle('expanded');
}

// Contact Form Functionality
function initContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // Validate required fields
        const requiredFields = ['firstName', 'lastName', 'email', 'country', 'investmentRange', 'investmentType', 'privacy'];
        let isValid = true;
        let firstErrorField = null;
        
        requiredFields.forEach(field => {
            const input = form.querySelector(`[name="${field}"]`);
            const value = data[field];
            
            if (!value || (field === 'privacy' && !input.checked)) {
                isValid = false;
                input.classList.add('error');
                
                if (!firstErrorField) {
                    firstErrorField = input;
                }
                
                // Remove error class after user interaction
                const removeError = () => {
                    input.classList.remove('error');
                    input.removeEventListener('input', removeError);
                    input.removeEventListener('change', removeError);
                };
                input.addEventListener('input', removeError);
                input.addEventListener('change', removeError);
            } else {
                input.classList.remove('error');
            }
        });
        
        // Validate email format
        if (data.email && !isValidEmail(data.email)) {
            isValid = false;
            const emailInput = form.querySelector('[name="email"]');
            emailInput.classList.add('error');
            if (!firstErrorField) {
                firstErrorField = emailInput;
            }
        }
        
        if (!isValid) {
            showNotification('Please fill in all required fields correctly.', 'error');
            if (firstErrorField) {
                firstErrorField.focus();
                firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('.contact-submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        submitBtn.disabled = true;
        
        // Simulate form submission (replace with actual API call)
        setTimeout(() => {
            // Reset form
            form.reset();
            
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            // Show success message
            showNotification('Thank you for your inquiry! Our team will contact you within 24 hours to schedule your confidential consultation.', 'success');
            
            // Optional: Scroll to top or redirect
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
        }, 2000);
    });
    
    // Add form field enhancements
    enhanceFormFields();
}

function enhanceFormFields() {
    // Add floating label effect
    const formGroups = document.querySelectorAll('.form-group');
    
    formGroups.forEach(group => {
        const input = group.querySelector('input, select, textarea');
        const label = group.querySelector('label');
        
        if (input && label) {
            // Add focus/blur effects
            input.addEventListener('focus', () => {
                group.classList.add('focused');
            });
            
            input.addEventListener('blur', () => {
                if (!input.value) {
                    group.classList.remove('focused');
                }
            });
            
            // Check if field has value on load
            if (input.value) {
                group.classList.add('focused');
            }
        }
    });
    
    // Add investment range formatting
    const investmentRange = document.querySelector('[name="investmentRange"]');
    if (investmentRange) {
        investmentRange.addEventListener('change', function() {
            const value = this.value;
            if (value) {
                // Add visual feedback for high-value selections
                if (value.includes('100M+') || value.includes('50-100M')) {
                    this.style.borderColor = '#5a6c57';
                    this.style.boxShadow = '0 0 0 3px rgba(90, 108, 87, 0.1)';
                }
            }
        });
    }
    
    // Add country selection enhancements
    const countrySelect = document.querySelector('[name="country"]');
    if (countrySelect) {
        countrySelect.addEventListener('change', function() {
            const value = this.value;
            if (value) {
                // Highlight key markets
                const keyMarkets = ['US', 'UK', 'CA', 'AU', 'DE', 'CH', 'SG', 'HK'];
                if (keyMarkets.includes(value)) {
                    this.style.borderColor = '#5a6c57';
                }
            }
        });
    }
}

// Smooth scrolling for navigation links (moved to main DOMContentLoaded)
function initSmoothScrollingLinks() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}