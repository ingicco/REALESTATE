# UAE Villa Specialists WordPress Theme

A fully responsive, mobile-first WordPress theme for luxury real estate businesses specializing in UAE villa sales. This theme transforms your static website into a dynamic, content-managed real estate portal.

## 🌟 Features

### 🏠 **Custom Property Management**
- **Custom Post Type**: Dedicated "Properties" post type with full CRUD functionality
- **Advanced Custom Fields**: Price, bedrooms, bathrooms, square footage, photo galleries, amenities
- **Property Taxonomies**: Communities and property types for organized categorization
- **Featured Properties**: Highlight premium listings on the homepage

### 🔍 **Advanced Property Search**
- **Real-time Filtering**: Search by community, bedrooms, price range, and keywords
- **AJAX-Powered**: Instant results without page reloads
- **Smart Sorting**: Featured, price (low/high), bedrooms, newest first
- **Responsive Pagination**: Seamless navigation through property listings

### 📱 **Mobile-First Design**
- **App-like Navigation**: Fixed bottom navigation bar on mobile devices
- **Touch-Optimized**: Large buttons and touch-friendly interactions
- **Single-Column Layouts**: Optimized mobile viewing experience
- **Performance Focused**: Fast loading with optimized assets

### 📝 **Content Management**
- **Standard Blog**: Full WordPress blog functionality with custom styling
- **Theme Customizer**: Easy customization of colors, text, and images
- **Widget Areas**: Blog sidebar and footer widget areas
- **SEO Ready**: Proper markup and meta tags for search engines

### 📧 **Lead Generation**
- **Property Inquiry Forms**: Individual contact forms for each property
- **Guide Download**: Lead magnet with email capture
- **AJAX Form Handling**: Smooth form submissions with validation
- **Email Notifications**: Automatic notifications to administrators

### 🗓️ **Scheduling Integration**
- **Calendly Integration**: Direct links to external scheduling services
- **Consultation Booking**: Multiple CTAs throughout the site
- **Customizable URLs**: Easy setup through WordPress Customizer

## 📁 File Structure

```
uae-villas/
├── style.css                 # Theme identifier
├── functions.php            # Theme functions and setup
├── index.php               # Homepage template
├── header.php              # Site header
├── footer.php              # Site footer
├── archive-property.php    # Properties archive page
├── single-property.php     # Single property template
├── home.php                # Blog archive template
├── single.php              # Single blog post template
├── assets/
│   ├── css/
│   │   ├── main.css        # Main theme styles
│   │   └── properties.css  # Property-specific styles
│   └── js/
│       ├── main.js         # Main theme JavaScript
│       └── properties.js   # Property functionality
├── inc/
│   ├── custom-post-types.php  # Property post type & fields
│   ├── customizer.php         # Theme customizer settings
│   ├── ajax-handlers.php      # AJAX form handlers
│   └── template-functions.php # Helper functions
└── template-parts/
    ├── property-card.php      # Property card template
    └── blog-card.php          # Blog post card template
```

## 🚀 Installation

### Prerequisites
- WordPress 6.0+
- PHP 8.0+
- Advanced Custom Fields (ACF) plugin (recommended)

### Installation Steps

1. **Upload Theme**
   ```bash
   # Copy the theme to your WordPress installation
   cp -r wp-theme/uae-villas /path/to/wordpress/wp-content/themes/
   ```

2. **Activate Theme**
   - Go to WordPress Admin → Appearance → Themes
   - Find "UAE Villa Specialists" and click "Activate"

3. **Install Recommended Plugins**
   - Advanced Custom Fields (for enhanced property fields)
   - Contact Form 7 (for guide download forms)
   - Yoast SEO (for search engine optimization)

4. **Configure Permalinks**
   - Go to Settings → Permalinks
   - Select "Post name" structure
   - Save changes to flush rewrite rules

## ⚙️ Configuration

### 1. Theme Customizer Settings

Navigate to **Appearance → Customize** to configure:

#### **Hero Section**
- Hero title and subtitle
- Background video URL
- Call-to-action button text

#### **Value Proposition**
- Three value proposition items
- Titles and descriptions for each

#### **Lead Magnet**
- Guide title and description
- Guide image upload
- Form integration settings

#### **Testimonial**
- Customer quote and attribution
- Testimonial image upload

#### **Scheduling Integration**
- Calendly URL for consultation bookings
- Applied to all "Book Consultation" buttons

### 2. Property Management

#### **Adding Properties**
1. Go to **Properties → Add New**
2. Fill in property details:
   - Title and description
   - Price (in AED)
   - Bedrooms and bathrooms
   - Square footage
   - Photo gallery
   - Amenities (checkboxes)
   - Map embed code
   - Featured property toggle

#### **Property Communities**
1. Go to **Properties → Communities**
2. Add communities like:
   - Palm Jumeirah
   - Dubai Hills Estate
   - Emirates Hills
   - Arabian Ranches

#### **Property Types**
1. Go to **Properties → Property Types**
2. Add types like:
   - Villa
   - Townhouse
   - Penthouse
   - Apartment

### 3. Blog Setup

#### **Create Blog Page**
1. Go to **Pages → Add New**
2. Create a page titled "Blog"
3. Go to **Settings → Reading**
4. Set "Posts page" to your Blog page

#### **Menu Setup**
1. Go to **Appearance → Menus**
2. Create a menu with:
   - Home
   - Properties
   - Blog
   - Contact
3. Assign to "Primary Menu" location

## 🎨 Customization

### **Colors and Branding**
The theme uses CSS custom properties for easy customization:

```css
:root {
    --color-bg-primary: #F8F8F8;
    --color-bg-dark: #1A202C;
    --color-text-primary: #2D3748;
    --color-accent: #D4AF37;
    --color-accent-hover: #B8941F;
}
```

### **Typography**
- Headlines: Playfair Display (serif)
- Body text: Manrope (sans-serif)
- Loaded via Google Fonts

### **Custom Fields (ACF)**
If ACF is installed, the theme automatically creates:
- Property Details field group
- Gallery field for multiple images
- Amenities checklist
- Map embed field

## 📧 Form Integration

### **Property Inquiry Forms**
- Each property has a contact form
- AJAX submission with validation
- Email notifications to admin
- Success/error messages

### **Guide Download Form**
- Lead magnet on homepage
- Email capture functionality
- Integration ready for MailChimp/ConvertKit

### **Email Configuration**
Forms use WordPress's built-in `wp_mail()` function. For better deliverability:
1. Install an SMTP plugin (WP Mail SMTP)
2. Configure with your email provider
3. Test form submissions

## 🔧 Development

### **Local Development**
```bash
# Start WordPress development environment
# (Using Local by Flywheel, XAMPP, or similar)

# Navigate to theme directory
cd wp-content/themes/uae-villas

# Make changes to CSS/JS files in assets/
# WordPress will automatically enqueue them
```

### **Customizing Templates**
- Override templates by copying to child theme
- Use WordPress template hierarchy
- Follow WordPress coding standards

### **Adding Custom Fields**
```php
// In functions.php or custom plugin
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_custom_fields',
        'title' => 'Custom Fields',
        'fields' => array(
            // Your custom fields here
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'property',
                ),
            ),
        ),
    ));
}
```

## 🚀 Performance Optimization

### **Built-in Optimizations**
- Lazy loading for images
- Efficient CSS and JavaScript loading
- Optimized database queries
- Responsive image sizes

### **Recommended Plugins**
- **WP Rocket**: Caching and performance
- **Smush**: Image optimization
- **Cloudflare**: CDN and security
- **WP Super Cache**: Alternative caching solution

## 🔒 Security Features

- Nonce verification for all forms
- Data sanitization and validation
- Proper user capability checks
- SQL injection prevention

## 📱 Mobile Optimization

### **Mobile Navigation**
- Fixed bottom navigation bar
- Instagram-style app experience
- Touch-friendly buttons
- Smooth scrolling between sections

### **Performance**
- Video backgrounds disabled on mobile
- Optimized image sizes
- Reduced JavaScript execution
- Fast loading times

## 🌐 SEO Features

- Semantic HTML structure
- Proper heading hierarchy
- Meta tags and descriptions
- Schema markup ready
- Fast loading speeds
- Mobile-first design

## 🆘 Troubleshooting

### **Common Issues**

#### **Properties Not Showing**
1. Check if custom post type is registered
2. Flush permalinks (Settings → Permalinks → Save)
3. Verify theme activation

#### **Forms Not Working**
1. Check AJAX URL in browser console
2. Verify nonce values
3. Test email configuration
4. Check server error logs

#### **Styling Issues**
1. Clear browser cache
2. Check for plugin conflicts
3. Verify CSS file loading
4. Use browser developer tools

#### **Mobile Navigation Not Working**
1. Check JavaScript console for errors
2. Verify mobile detection
3. Clear cache and test on actual device

## 📞 Support

For theme support and customization:

1. **Documentation**: Check this README first
2. **WordPress Codex**: Official WordPress documentation
3. **ACF Documentation**: For custom field issues
4. **Community Forums**: WordPress.org support forums

## 📄 License

This theme is licensed under the GPL v2 or later.

## 🔄 Updates

### **Version 1.0.0**
- Initial release
- Custom property post type
- Advanced search functionality
- Mobile-first responsive design
- Blog integration
- Scheduling integration
- Lead generation forms

---

**Built for luxury real estate professionals who demand excellence in both design and functionality.**


