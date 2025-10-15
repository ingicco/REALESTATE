<?php
/**
 * The main template file
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

get_header(); ?>

<!-- Hero Section -->
<section id="hero" class="hero">
    <div class="hero-video-container">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="<?php echo esc_url(get_theme_mod('hero_video_url', UAE_VILLAS_THEME_URL . '/assets/images/hero-video.mp4')); ?>" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
    </div>
    <div class="hero-content">
        <h1 class="hero-title"><?php echo esc_html(get_theme_mod('hero_title', 'From Relocation to Residence: Your Trusted Partner in Finding Your Dream UAE Villa')); ?></h1>
        <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('hero_subtitle', 'We specialize in making your international move seamless, providing expert guidance on Dubai\'s exclusive villa communities, Golden Visas, and family life.')); ?></p>
        <div class="hero-buttons">
            <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn btn-primary">Explore Villa Collections</a>
            <a href="#guides" class="btn btn-secondary">Download Free Relocation Guide</a>
        </div>
    </div>
</section>

<!-- Featured Villa Collection -->
<section id="villas" class="featured-villas">
    <div class="container">
        <h2 class="section-title">Curated for the Discerning Global Citizen</h2>
        <div class="villa-grid">
            <?php
            $featured_properties = new WP_Query(array(
                'post_type' => 'property',
                'posts_per_page' => 3,
                'meta_key' => '_property_featured',
                'meta_value' => '1',
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            if ($featured_properties->have_posts()) :
                while ($featured_properties->have_posts()) : $featured_properties->the_post();
                    get_template_part('template-parts/property-card');
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback: Show latest 3 properties if no featured ones
                $latest_properties = new WP_Query(array(
                    'post_type' => 'property',
                    'posts_per_page' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));
                
                if ($latest_properties->have_posts()) :
                    while ($latest_properties->have_posts()) : $latest_properties->the_post();
                        get_template_part('template-parts/property-card');
                    endwhile;
                    wp_reset_postdata();
                endif;
            endif;
            ?>
        </div>
        
        <!-- Portfolio CTA Button -->
        <div class="portfolio-cta">
            <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn btn-primary btn-large">Explore Our Full Villa Portfolio</a>
        </div>
    </div>
</section>

<!-- Value Proposition -->
<section id="value-proposition" class="value-proposition">
    <div class="container">
        <h2 class="section-title">More Than an Agent. We Are Your Relocation Strategist.</h2>
        <div class="value-grid">
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="value-title"><?php echo esc_html(get_theme_mod('value_1_title', 'Community Matching')); ?></h3>
                <p class="value-description"><?php echo esc_html(get_theme_mod('value_1_description', 'We don\'t just find a property; we find your place. Our deep knowledge of Dubai\'s neighborhoods ensures the perfect fit for your lifestyle.')); ?></p>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="value-title"><?php echo esc_html(get_theme_mod('value_2_title', 'Effortless Process')); ?></h3>
                <p class="value-description"><?php echo esc_html(get_theme_mod('value_2_description', 'From virtual viewings to legal paperwork, we manage every detail. Your international move becomes a seamless, stress-free experience.')); ?></p>
            </div>
            
            <div class="value-item">
                <div class="value-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="value-title"><?php echo esc_html(get_theme_mod('value_3_title', 'Investment Intelligence')); ?></h3>
                <p class="value-description"><?php echo esc_html(get_theme_mod('value_3_description', 'Find a beautiful home that is also a sound financial investment. We provide market insights to maximize your property\'s potential.')); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Lead Magnet -->
<section id="guides" class="lead-magnet">
    <div class="container">
        <div class="lead-magnet-content">
            <div class="guide-image">
                <img src="<?php echo esc_url(get_theme_mod('guide_image', 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1974&q=80')); ?>" alt="UAE Relocation Guide">
            </div>
            <div class="guide-content">
                <h2 class="guide-title"><?php echo esc_html(get_theme_mod('guide_title', 'Your Essential Guide to a Successful Move')); ?></h2>
                <p class="guide-description"><?php echo esc_html(get_theme_mod('guide_description', 'Our complimentary 2025 Relocation Guide covers the entire buying process, visa requirements, school systems, and associated costs.')); ?></p>
                <?php echo do_shortcode('[contact-form-7 id="' . get_theme_mod('guide_form_id', '') . '" title="Guide Download Form"]'); ?>
            </div>
        </div>
    </div>
</section>

<!-- Client Testimonial -->
<section id="testimonial" class="testimonial">
    <div class="container">
        <h2 class="section-title">The Journeys We've Guided</h2>
        <div class="testimonial-content">
            <div class="testimonial-image">
                <img src="<?php echo esc_url(get_theme_mod('testimonial_image', 'https://images.unsplash.com/photo-1600298881974-6be191ceeda1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2128&q=80')); ?>" alt="Happy Client Family">
            </div>
            <div class="testimonial-text">
                <blockquote class="testimonial-quote">
                    "<?php echo esc_html(get_theme_mod('testimonial_quote', 'Moving our family from London was a monumental task. Their team found us a home in Dubai Hills that exceeded all expectations. The process was transparent and remarkably smooth.')); ?>"
                </blockquote>
                <cite class="testimonial-attribution"><?php echo esc_html(get_theme_mod('testimonial_attribution', 'The Henderson Family, from London, UK')); ?></cite>
            </div>
        </div>
    </div>
</section>

<!-- Final CTA -->
<section id="contact" class="final-cta">
    <div class="container">
        <h2 class="cta-title"><?php echo esc_html(get_theme_mod('final_cta_title', 'Ready to Begin Your Journey?')); ?></h2>
        <p class="cta-subtitle"><?php echo esc_html(get_theme_mod('final_cta_subtitle', 'Schedule a no-obligation discovery call to discuss your ambitions.')); ?></p>
        <a href="<?php echo esc_url(get_theme_mod('calendly_url', 'https://calendly.com/your-account')); ?>" class="btn btn-primary btn-large" target="_blank">Book a Consultation</a>
    </div>
</section>

<?php get_footer(); ?>


