// ===== MOBILE NAVIGATION & SMOOTH SCROLLING =====

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile navigation
    initMobileNavigation();
    
    // Initialize smooth scrolling for all anchor links
    initSmoothScrolling();
    
    // Initialize form handling
    initFormHandling();
    
    // Initialize scroll-based animations
    initScrollAnimations();
    
    // Initialize intersection observer for navigation active states
    initNavigationObserver();
});

// Mobile Navigation Management
function initMobileNavigation() {
    const mobileNav = document.getElementById('mobileNav');
    const navItems = mobileNav.querySelectorAll('.nav-item');
    
    // Handle navigation item clicks
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Get target section
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                // Smooth scroll to section
                const offsetTop = targetSection.offsetTop;
                const isMobile = window.innerWidth <= 767;
                const offset = isMobile ? 20 : 80; // Account for mobile nav height
                
                window.scrollTo({
                    top: offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Smooth Scrolling for All Anchor Links
function initSmoothScrolling() {
    // Handle hero button clicks
    const exploreBtn = document.querySelector('.hero-buttons .btn-primary');
    const guideBtn = document.querySelector('.hero-buttons .btn-secondary');
    
    if (exploreBtn) {
        exploreBtn.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToSection('villas');
        });
    }
    
    if (guideBtn) {
        guideBtn.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToSection('guides');
        });
    }
    
    // Handle consultation button
    const consultationBtn = document.querySelector('.final-cta .btn-primary');
    if (consultationBtn) {
        consultationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // In a real implementation, this would open a booking modal or redirect to a booking page
            showBookingModal();
        });
    }
    
    // Handle villa detail buttons
    const villaButtons = document.querySelectorAll('.villa-card .btn-outline');
    villaButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            // In a real implementation, this would show villa details
            showVillaDetails(this);
        });
    });
    
    // Handle portfolio CTA button
    const portfolioBtn = document.querySelector('.portfolio-cta .btn');
    if (portfolioBtn) {
        portfolioBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Navigate to properties page
            window.location.href = '/properties.html';
        });
    }
}

// Scroll to Section Helper
function scrollToSection(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        const offsetTop = section.offsetTop;
        const isMobile = window.innerWidth <= 767;
        const offset = isMobile ? 20 : 80;
        
        window.scrollTo({
            top: offsetTop - offset,
            behavior: 'smooth'
        });
        
        // Update mobile nav active state
        updateMobileNavActive(sectionId);
    }
}

// Update Mobile Navigation Active State
function updateMobileNavActive(sectionId) {
    const navItems = document.querySelectorAll('.mobile-nav .nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-section') === sectionId) {
            item.classList.add('active');
        }
    });
}

// Form Handling
function initFormHandling() {
    const guideForm = document.getElementById('guideForm');
    
    if (guideForm) {
        guideForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const firstName = document.getElementById('firstName').value;
            const email = document.getElementById('email').value;
            
            // Basic validation
            if (!firstName.trim() || !email.trim()) {
                showNotification('Please fill in all fields.', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }
            
            // Simulate form submission
            submitGuideForm(firstName, email);
        });
    }
}

// Email Validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Simulate Guide Form Submission
function submitGuideForm(firstName, email) {
    // Show loading state
    const submitBtn = document.querySelector('#guideForm .btn-primary');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Sending...';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Reset button
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
        // Clear form
        document.getElementById('firstName').value = '';
        document.getElementById('email').value = '';
        
        // Show success message
        showNotification(`Thank you, ${firstName}! Your guide will be sent to ${email} shortly.`, 'success');
        
        // In a real implementation, you would send this data to your backend
        console.log('Form submitted:', { firstName, email });
    }, 2000);
}

// Notification System
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#48BB78' : type === 'error' ? '#F56565' : '#4299E1'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 10000;
        max-width: 400px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Handle close button
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.remove();
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animatedElements = document.querySelectorAll('.villa-card, .value-item, .testimonial-content');
    animatedElements.forEach(el => observer.observe(el));
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
                    if (item.getAttribute('data-section') === sectionId) {
                        item.classList.add('active');
                    }
                });
            }
        });
    }, observerOptions);
    
    sections.forEach(section => observer.observe(section));
}

// Modal Functions (Placeholder implementations)
function showBookingModal() {
    // In a real implementation, this would open a booking modal
    // For now, we'll show a notification
    showNotification('Booking system would open here. Contact us at info@uaevillas.com', 'info');
}

function showVillaDetails(button) {
    // In a real implementation, this would show detailed villa information
    const villaCard = button.closest('.villa-card');
    const villaTitle = villaCard.querySelector('.villa-title').textContent;
    showNotification(`Detailed information for "${villaTitle}" would be displayed here.`, 'info');
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
    // Recalculate any dynamic positioning if needed
    const isMobile = window.innerWidth <= 767;
    
    // Update body padding for mobile nav
    if (isMobile) {
        document.body.style.paddingBottom = '80px';
    } else {
        document.body.style.paddingBottom = '0';
    }
}, 250));

// Add CSS for notification animations
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
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
    
    .notification-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }
    
    .notification-close:hover {
        opacity: 0.8;
    }
`;
document.head.appendChild(notificationStyles);

// Initialize lazy loading for images (performance optimization)
function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => imageObserver.observe(img));
    }
}

// Call lazy loading initialization
initLazyLoading();
