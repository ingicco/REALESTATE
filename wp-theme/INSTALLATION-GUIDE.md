# WordPress Theme Installation Guide

## Quick Start Guide for UAE Villa Specialists Theme

### 📋 Prerequisites

Before installing the theme, ensure you have:

- ✅ WordPress 6.0 or higher
- ✅ PHP 8.0 or higher  
- ✅ MySQL 5.7 or higher
- ✅ Admin access to WordPress dashboard

### 🚀 Step-by-Step Installation

#### Step 1: Upload the Theme

**Option A: Via WordPress Admin (Recommended)**
1. Download the theme folder `uae-villas`
2. Create a ZIP file of the `uae-villas` folder
3. Go to **WordPress Admin → Appearance → Themes**
4. Click **Add New → Upload Theme**
5. Choose your ZIP file and click **Install Now**
6. Click **Activate** when installation completes

**Option B: Via FTP/File Manager**
1. Upload the `uae-villas` folder to `/wp-content/themes/`
2. Go to **WordPress Admin → Appearance → Themes**
3. Find "UAE Villa Specialists" and click **Activate**

#### Step 2: Install Required Plugins

Install these recommended plugins for full functionality:

1. **Advanced Custom Fields (ACF)** - For enhanced property fields
   - Go to **Plugins → Add New**
   - Search for "Advanced Custom Fields"
   - Install and activate

2. **Contact Form 7** - For lead generation forms
   - Search for "Contact Form 7"
   - Install and activate

#### Step 3: Configure Permalinks

1. Go to **Settings → Permalinks**
2. Select **Post name** structure
3. Click **Save Changes**

This ensures clean URLs like `/properties/luxury-villa-palm-jumeirah/`

#### Step 4: Set Up Menus

1. Go to **Appearance → Menus**
2. Create a new menu called "Primary Menu"
3. Add these pages:
   - **Home** (link to your homepage)
   - **Properties** (link to `/properties/`)
   - **Blog** (link to your blog page)
   - **Contact** (custom link to `/#contact`)
4. Assign to **Primary Menu** location
5. Save menu

#### Step 5: Configure Theme Settings

Go to **Appearance → Customize** and configure:

**Hero Section:**
- Hero Title: "From Relocation to Residence: Your Trusted Partner in Finding Your Dream UAE Villa"
- Hero Subtitle: "We specialize in making your international move seamless..."
- Hero Video URL: (optional - add your video URL)

**Scheduling Integration:**
- Calendly URL: Replace with your actual Calendly booking link
- Example: `https://calendly.com/your-username/consultation`

**Value Proposition, Testimonial, etc.:**
- Customize all text content to match your business

### 🏠 Setting Up Properties

#### Step 1: Add Property Communities

1. Go to **Properties → Communities**
2. Add these communities:
   - Palm Jumeirah
   - Dubai Hills Estate
   - Emirates Hills
   - Arabian Ranches
   - Jumeirah Golf Estates
   - Al Barari
   - Mohammed Bin Rashid City
   - DAMAC Hills

#### Step 2: Add Property Types

1. Go to **Properties → Property Types**
2. Add these types:
   - Villa
   - Townhouse
   - Penthouse
   - Apartment

#### Step 3: Create Your First Property

1. Go to **Properties → Add New**
2. Fill in the details:
   - **Title**: "Luxury 5-Bedroom Villa in Dubai Hills Estate"
   - **Description**: Write a compelling property description
   - **Featured Image**: Upload a high-quality exterior photo
   - **Property Details**:
     - Price: 25000000 (AED)
     - Bedrooms: 5
     - Bathrooms: 6
     - Square Feet: 7000
   - **Gallery**: Upload 5-10 interior/exterior photos
   - **Amenities**: Check relevant amenities
   - **Community**: Select "Dubai Hills Estate"
   - **Featured Property**: Check if this should be featured
   - **Map Embed**: Add Google Maps embed code

3. **Publish** the property

### 📝 Setting Up Blog

#### Step 1: Create Blog Page

1. Go to **Pages → Add New**
2. Title: "Blog" or "Real Estate Insights"
3. Leave content empty (the theme will handle the layout)
4. **Publish**

#### Step 2: Configure Reading Settings

1. Go to **Settings → Reading**
2. Set **Posts page** to your Blog page
3. **Save Changes**

#### Step 3: Create Sample Blog Posts

Create a few blog posts about:
- UAE real estate market trends
- Buying guide for international clients
- Community spotlights
- Investment opportunities

### 📧 Setting Up Forms

#### Step 1: Configure Email Settings

For reliable email delivery, install **WP Mail SMTP**:
1. Install the plugin
2. Configure with your email provider (Gmail, Outlook, etc.)
3. Test email functionality

#### Step 2: Test Property Inquiry Forms

1. Visit a property page
2. Fill out the inquiry form
3. Verify emails are received
4. Check spam folder if needed

### 🎨 Customization Tips

#### Colors and Branding

To change the accent color from gold to your brand color:

1. Go to **Appearance → Theme Editor**
2. Select **main.css**
3. Find the `:root` section
4. Change `--color-accent: #D4AF37;` to your color
5. Change `--color-accent-hover` to a darker shade

#### Logo Upload

1. Go to **Appearance → Customize → Site Identity**
2. Upload your logo
3. The theme will automatically display it in the header

### 📱 Mobile Testing

Test your site on mobile devices:

1. **Responsive Design**: Resize browser window
2. **Mobile Navigation**: Check bottom navigation bar
3. **Touch Interactions**: Test all buttons and forms
4. **Loading Speed**: Ensure fast loading on mobile

### 🔧 Troubleshooting

#### Properties Page Shows 404

1. Go to **Settings → Permalinks**
2. Click **Save Changes** (this flushes rewrite rules)
3. Check if the issue is resolved

#### Forms Not Working

1. Check if Contact Form 7 is installed and active
2. Verify email settings in **WP Mail SMTP**
3. Check server error logs
4. Test with a simple contact form first

#### Styling Issues

1. Clear browser cache
2. Check for plugin conflicts by deactivating all plugins
3. Switch to a default theme temporarily to isolate the issue
4. Check browser console for JavaScript errors

### 🚀 Going Live

#### Pre-Launch Checklist

- [ ] All property information is accurate
- [ ] Contact forms are working
- [ ] Calendly integration is set up
- [ ] Mobile navigation works properly
- [ ] All images are optimized
- [ ] SEO plugin is configured
- [ ] SSL certificate is installed
- [ ] Backup system is in place

#### Performance Optimization

1. Install **WP Rocket** or similar caching plugin
2. Optimize images with **Smush** or **ShortPixel**
3. Set up **Cloudflare** for CDN
4. Enable GZIP compression
5. Minify CSS and JavaScript

### 📞 Need Help?

If you encounter issues:

1. **Check the README.md** in the theme folder
2. **WordPress Codex**: https://codex.wordpress.org/
3. **ACF Documentation**: https://www.advancedcustomfields.com/resources/
4. **Contact Form 7 Docs**: https://contactform7.com/docs/

### 🎯 Next Steps

After installation:

1. **Add more properties** to populate your portfolio
2. **Create valuable blog content** for SEO
3. **Set up Google Analytics** for tracking
4. **Configure backup solution** for security
5. **Test all functionality** thoroughly
6. **Train your team** on content management

---

**Congratulations! Your luxury real estate website is now ready to generate leads and showcase your UAE villa portfolio.**


