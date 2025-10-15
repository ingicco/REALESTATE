// ===== PROPERTIES PAGE FUNCTIONALITY =====

// Sample property data (in a real application, this would come from an API)
const SAMPLE_PROPERTIES = [
    {
        id: 1,
        title: "Exquisite 5-Bedroom Villa",
        location: "Dubai Hills Estate",
        community: "dubai-hills",
        bedrooms: 5,
        bathrooms: 6,
        sqft: 7000,
        price: 25000000,
        image: "https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80",
        features: ["Pool", "Garden", "Garage"],
        badge: "Featured",
        keywords: ["golf view", "family friendly", "modern"]
    },
    {
        id: 2,
        title: "Contemporary Masterpiece",
        location: "Emirates Hills",
        community: "emirates-hills",
        bedrooms: 6,
        bathrooms: 7,
        sqft: 9500,
        price: 45000000,
        image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=2075&q=80",
        features: ["Pool", "Gym", "Cinema"],
        badge: "Luxury",
        keywords: ["contemporary", "luxury", "exclusive"]
    },
    {
        id: 3,
        title: "Waterfront Paradise",
        location: "Palm Jumeirah",
        community: "palm-jumeirah",
        bedrooms: 4,
        bathrooms: 5,
        sqft: 6200,
        price: 35000000,
        image: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2053&q=80",
        features: ["Beach Access", "Pool", "Terrace"],
        badge: "Waterfront",
        keywords: ["beach", "waterfront", "sea view"]
    },
    {
        id: 4,
        title: "Golf Course Villa",
        location: "Jumeirah Golf Estates",
        community: "jumeirah-golf",
        bedrooms: 5,
        bathrooms: 6,
        sqft: 8200,
        price: 28000000,
        image: "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80",
        features: ["Golf View", "Pool", "Garden"],
        badge: "Golf View",
        keywords: ["golf", "sports", "green view"]
    },
    {
        id: 5,
        title: "Modern Family Estate",
        location: "Arabian Ranches",
        community: "arabian-ranches",
        bedrooms: 4,
        bathrooms: 5,
        sqft: 5800,
        price: 18000000,
        image: "https://images.unsplash.com/photo-1505843513577-22bb7d21e455?ixlib=rb-4.0.3&auto=format&fit=crop&w=2026&q=80",
        features: ["Pool", "Garden", "Playground"],
        badge: "Family",
        keywords: ["family", "community", "safe"]
    },
    {
        id: 6,
        title: "Luxury Eco Villa",
        location: "Al Barari",
        community: "al-barari",
        bedrooms: 6,
        bathrooms: 7,
        sqft: 10000,
        price: 55000000,
        image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80",
        features: ["Eco-Friendly", "Pool", "Spa"],
        badge: "Eco-Luxury",
        keywords: ["eco", "sustainable", "green", "nature"]
    },
    {
        id: 7,
        title: "Ultra-Modern Penthouse Villa",
        location: "Mohammed Bin Rashid City",
        community: "mohammed-bin-rashid",
        bedrooms: 7,
        bathrooms: 8,
        sqft: 12000,
        price: 75000000,
        image: "https://images.unsplash.com/photo-1613977257363-707ba9348227?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80",
        features: ["Skyline View", "Pool", "Elevator"],
        badge: "Ultra-Luxury",
        keywords: ["penthouse", "skyline", "modern", "luxury"]
    },
    {
        id: 8,
        title: "Championship Golf Villa",
        location: "DAMAC Hills",
        community: "damac-hills",
        bedrooms: 5,
        bathrooms: 6,
        sqft: 7500,
        price: 22000000,
        image: "https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80",
        features: ["Golf Course", "Pool", "Club Access"],
        badge: "Golf",
        keywords: ["golf", "championship", "club", "sports"]
    }
];

// Generate additional properties for pagination demo
function generateMoreProperties() {
    const additionalProperties = [];
    const baseProperties = [...SAMPLE_PROPERTIES];
    
    for (let i = 0; i < 16; i++) {
        const baseProperty = baseProperties[i % baseProperties.length];
        additionalProperties.push({
            ...baseProperty,
            id: baseProperty.id + (i + 1) * 10,
            title: `${baseProperty.title} ${i + 9}`,
            price: baseProperty.price + (Math.random() * 10000000 - 5000000)
        });
    }
    
    return [...SAMPLE_PROPERTIES, ...additionalProperties];
}

const ALL_PROPERTIES = generateMoreProperties();

// State management
let currentFilters = {
    searchKeyword: '',
    community: '',
    bedrooms: '',
    priceRange: '',
    sortBy: 'featured'
};

let currentPage = 1;
const propertiesPerPage = 9;
let filteredProperties = [...ALL_PROPERTIES];

// Initialize properties page
document.addEventListener('DOMContentLoaded', function() {
    initializePropertiesPage();
});

function initializePropertiesPage() {
    // Initialize form handlers
    initializeFilters();
    
    // Initialize pagination
    initializePagination();
    
    // Load initial properties
    displayProperties();
    
    // Initialize mobile navigation
    initializeMobileNav();
    
    // Update URL handling
    handleURLNavigation();
}

// Filter functionality
function initializeFilters() {
    const filterForm = document.getElementById('propertyFilters');
    const sortSelect = document.getElementById('sortBy');
    
    // Handle filter form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });
    
    // Handle real-time filtering for text input
    const searchInput = document.getElementById('searchKeyword');
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            applyFilters();
        }, 500);
    });
    
    // Handle dropdown changes
    const dropdowns = filterForm.querySelectorAll('select');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('change', applyFilters);
    });
    
    // Handle sort changes
    sortSelect.addEventListener('change', function() {
        currentFilters.sortBy = this.value;
        applyFilters();
    });
}

function applyFilters() {
    // Show loading state
    showLoadingState();
    
    // Get filter values
    currentFilters = {
        searchKeyword: document.getElementById('searchKeyword').value.toLowerCase(),
        community: document.getElementById('community').value,
        bedrooms: document.getElementById('bedrooms').value,
        priceRange: document.getElementById('priceRange').value,
        sortBy: document.getElementById('sortBy').value
    };
    
    // Reset to first page
    currentPage = 1;
    
    // Apply filters
    filteredProperties = ALL_PROPERTIES.filter(property => {
        // Search keyword filter
        if (currentFilters.searchKeyword) {
            const searchMatch = 
                property.title.toLowerCase().includes(currentFilters.searchKeyword) ||
                property.location.toLowerCase().includes(currentFilters.searchKeyword) ||
                property.keywords.some(keyword => keyword.includes(currentFilters.searchKeyword));
            
            if (!searchMatch) return false;
        }
        
        // Community filter
        if (currentFilters.community && property.community !== currentFilters.community) {
            return false;
        }
        
        // Bedrooms filter
        if (currentFilters.bedrooms && property.bedrooms < parseInt(currentFilters.bedrooms)) {
            return false;
        }
        
        // Price range filter
        if (currentFilters.priceRange) {
            const [min, max] = currentFilters.priceRange.split('-').map(Number);
            if (property.price < min || (max && property.price > max)) {
                return false;
            }
        }
        
        return true;
    });
    
    // Apply sorting
    applySorting();
    
    // Simulate API delay
    setTimeout(() => {
        hideLoadingState();
        displayProperties();
        updatePagination();
        updateResultsCount();
    }, 800);
}

function applySorting() {
    switch (currentFilters.sortBy) {
        case 'price-low':
            filteredProperties.sort((a, b) => a.price - b.price);
            break;
        case 'price-high':
            filteredProperties.sort((a, b) => b.price - a.price);
            break;
        case 'bedrooms':
            filteredProperties.sort((a, b) => b.bedrooms - a.bedrooms);
            break;
        case 'newest':
            filteredProperties.sort((a, b) => b.id - a.id);
            break;
        case 'featured':
        default:
            // Keep original order for featured
            break;
    }
}

function displayProperties() {
    const grid = document.getElementById('propertiesGrid');
    const startIndex = (currentPage - 1) * propertiesPerPage;
    const endIndex = startIndex + propertiesPerPage;
    const currentProperties = filteredProperties.slice(startIndex, endIndex);
    
    if (currentProperties.length === 0) {
        showNoResults();
        return;
    }
    
    hideNoResults();
    
    grid.innerHTML = currentProperties.map(property => createPropertyCard(property)).join('');
    
    // Add click handlers for property cards
    addPropertyCardHandlers();
}

function createPropertyCard(property) {
    const formattedPrice = new Intl.NumberFormat('en-AE', {
        style: 'currency',
        currency: 'AED',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(property.price);
    
    return `
        <div class="property-card" data-property-id="${property.id}">
            <div class="property-image">
                <img src="${property.image}" alt="${property.title}">
                <div class="property-badge">${property.badge}</div>
            </div>
            <div class="property-info">
                <div class="property-location">${property.location}</div>
                <h3 class="property-title">${property.title}</h3>
                <p class="property-details">${property.bedrooms} Beds | ${property.bathrooms} Baths | ${property.sqft.toLocaleString()} sq. ft.</p>
                <div class="property-features">
                    ${property.features.slice(0, 3).map(feature => `
                        <span><i class="fas fa-check"></i> ${feature}</span>
                    `).join('')}
                </div>
                <p class="property-price">${formattedPrice}</p>
                <div class="property-actions">
                    <button class="btn btn-outline btn-small view-details-btn">View Details</button>
                    <button class="btn btn-primary btn-small contact-btn">Contact Agent</button>
                </div>
            </div>
        </div>
    `;
}

function addPropertyCardHandlers() {
    // View details buttons
    document.querySelectorAll('.view-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const propertyCard = this.closest('.property-card');
            const propertyId = propertyCard.dataset.propertyId;
            showPropertyDetails(propertyId);
        });
    });
    
    // Contact agent buttons
    document.querySelectorAll('.contact-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const propertyCard = this.closest('.property-card');
            const propertyId = propertyCard.dataset.propertyId;
            contactAgent(propertyId);
        });
    });
}

// Pagination functionality
function initializePagination() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayProperties();
            updatePagination();
            scrollToTop();
        }
    });
    
    nextBtn.addEventListener('click', () => {
        const totalPages = Math.ceil(filteredProperties.length / propertiesPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            displayProperties();
            updatePagination();
            scrollToTop();
        }
    });
}

function updatePagination() {
    const totalPages = Math.ceil(filteredProperties.length / propertiesPerPage);
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const paginationNumbers = document.getElementById('paginationNumbers');
    const paginationInfo = document.getElementById('paginationInfo');
    
    // Update button states
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages || totalPages === 0;
    
    // Update page numbers
    paginationNumbers.innerHTML = '';
    
    if (totalPages > 0) {
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, startPage + 4);
        
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement('a');
            pageBtn.href = '#';
            pageBtn.className = `pagination-number ${i === currentPage ? 'active' : ''}`;
            pageBtn.textContent = i;
            pageBtn.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                displayProperties();
                updatePagination();
                scrollToTop();
            });
            paginationNumbers.appendChild(pageBtn);
        }
    }
    
    // Update pagination info
    paginationInfo.textContent = totalPages > 0 ? `Page ${currentPage} of ${totalPages}` : '';
}

// Utility functions
function showLoadingState() {
    document.getElementById('propertiesGrid').style.display = 'none';
    document.getElementById('loadingState').style.display = 'block';
    document.getElementById('noResults').style.display = 'none';
}

function hideLoadingState() {
    document.getElementById('propertiesGrid').style.display = 'grid';
    document.getElementById('loadingState').style.display = 'none';
}

function showNoResults() {
    document.getElementById('propertiesGrid').style.display = 'none';
    document.getElementById('loadingState').style.display = 'none';
    document.getElementById('noResults').style.display = 'block';
}

function hideNoResults() {
    document.getElementById('noResults').style.display = 'none';
}

function updateResultsCount() {
    const resultsCount = document.getElementById('resultsCount');
    const startIndex = (currentPage - 1) * propertiesPerPage + 1;
    const endIndex = Math.min(currentPage * propertiesPerPage, filteredProperties.length);
    
    if (filteredProperties.length === 0) {
        resultsCount.textContent = 'No properties found';
    } else {
        resultsCount.textContent = `Showing ${startIndex}-${endIndex} of ${filteredProperties.length} properties`;
    }
}

function clearFilters() {
    document.getElementById('propertyFilters').reset();
    document.getElementById('sortBy').value = 'featured';
    currentFilters = {
        searchKeyword: '',
        community: '',
        bedrooms: '',
        priceRange: '',
        sortBy: 'featured'
    };
    currentPage = 1;
    filteredProperties = [...ALL_PROPERTIES];
    displayProperties();
    updatePagination();
    updateResultsCount();
}

function scrollToTop() {
    const propertiesSection = document.querySelector('.property-listings');
    propertiesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Property interaction functions
function showPropertyDetails(propertyId) {
    const property = ALL_PROPERTIES.find(p => p.id == propertyId);
    if (property) {
        // In a real application, this would navigate to a detailed property page
        showNotification(`Detailed view for "${property.title}" would open here. Property ID: ${propertyId}`, 'info');
    }
}

function contactAgent(propertyId) {
    const property = ALL_PROPERTIES.find(p => p.id == propertyId);
    if (property) {
        // In a real application, this would open a contact form or initiate contact
        showNotification(`Contact form for "${property.title}" would open here. An agent will reach out shortly.`, 'success');
    }
}

// Mobile navigation
function initializeMobileNav() {
    const navItems = document.querySelectorAll('.mobile-nav .nav-item');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Handle internal page navigation
            if (href.startsWith('/#')) {
                e.preventDefault();
                // Navigate to homepage with hash
                window.location.href = '/' + href.substring(1);
            }
        });
    });
}

// URL navigation handling
function handleURLNavigation() {
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(e) {
        // Handle navigation state if needed
    });
    
    // Update page title
    document.title = 'Our Villa Portfolio - UAE Villa Specialists';
}

// Notification system (reuse from main script)
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

// Initialize on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializePropertiesPage);
} else {
    initializePropertiesPage();
}


