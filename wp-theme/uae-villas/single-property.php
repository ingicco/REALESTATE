<?php
/**
 * The template for displaying single property
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- Property Hero Section -->
<section class="property-hero">
    <?php
    $gallery = get_field('property_gallery');
    if ($gallery && is_array($gallery) && count($gallery) > 1) :
        // Multiple images - show slider
        ?>
        <div class="property-gallery-slider">
            <div class="gallery-main">
                <?php foreach ($gallery as $index => $image) : ?>
                    <div class="gallery-slide <?php echo ($index === 0) ? 'active' : ''; ?>">
                        <img src="<?php echo esc_url($image['sizes']['property-hero']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="gallery-thumbnails">
                <?php foreach ($gallery as $index => $image) : ?>
                    <button class="gallery-thumb <?php echo ($index === 0) ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </button>
                <?php endforeach; ?>
            </div>
            
            <button class="gallery-prev"><i class="fas fa-chevron-left"></i></button>
            <button class="gallery-next"><i class="fas fa-chevron-right"></i></button>
        </div>
    <?php elseif (has_post_thumbnail()) : ?>
        <!-- Single featured image -->
        <div class="property-single-image">
            <?php the_post_thumbnail('property-hero'); ?>
        </div>
    <?php else : ?>
        <!-- Fallback placeholder -->
        <div class="property-placeholder">
            <i class="fas fa-home"></i>
            <p><?php esc_html_e('Property Image Coming Soon', 'uae-villas'); ?></p>
        </div>
    <?php endif; ?>
    
    <!-- Property Badge -->
    <?php if (get_field('property_featured')) : ?>
        <div class="property-badge featured">
            <?php esc_html_e('Featured', 'uae-villas'); ?>
        </div>
    <?php endif; ?>
</section>

<!-- Property Details Section -->
<section class="property-details">
    <div class="container">
        <div class="property-content">
            <div class="property-main">
                <!-- Property Header -->
                <div class="property-header">
                    <div class="property-location">
                        <?php
                        $communities = get_the_terms(get_the_ID(), 'property_community');
                        if ($communities && !is_wp_error($communities)) {
                            echo esc_html($communities[0]->name);
                        }
                        ?>
                    </div>
                    <h1 class="property-title"><?php the_title(); ?></h1>
                    
                    <div class="property-meta">
                        <div class="property-specs">
                            <?php if (get_field('property_bedrooms')) : ?>
                                <span class="spec-item">
                                    <i class="fas fa-bed"></i>
                                    <?php printf(esc_html__('%d Bedrooms', 'uae-villas'), get_field('property_bedrooms')); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (get_field('property_bathrooms')) : ?>
                                <span class="spec-item">
                                    <i class="fas fa-bath"></i>
                                    <?php printf(esc_html__('%d Bathrooms', 'uae-villas'), get_field('property_bathrooms')); ?>
                                </span>
                            <?php endif; ?>
                            
                            <?php if (get_field('property_sqft')) : ?>
                                <span class="spec-item">
                                    <i class="fas fa-ruler-combined"></i>
                                    <?php echo number_format(get_field('property_sqft')); ?> sq. ft.
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="property-price">
                            <?php
                            $price = get_field('property_price');
                            if ($price) {
                                echo 'AED ' . number_format($price);
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- Property Description -->
                <div class="property-description">
                    <h2><?php esc_html_e('About This Property', 'uae-villas'); ?></h2>
                    <div class="description-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <!-- Property Amenities -->
                <?php
                $amenities = get_field('property_amenities');
                if ($amenities && is_array($amenities)) :
                ?>
                <div class="property-amenities">
                    <h2><?php esc_html_e('Amenities & Features', 'uae-villas'); ?></h2>
                    <div class="amenities-grid">
                        <?php
                        $amenity_labels = array(
                            'pool' => __('Swimming Pool', 'uae-villas'),
                            'gym' => __('Gym/Fitness Center', 'uae-villas'),
                            'garden' => __('Garden', 'uae-villas'),
                            'garage' => __('Garage', 'uae-villas'),
                            'balcony' => __('Balcony/Terrace', 'uae-villas'),
                            'maid_room' => __('Maid\'s Room', 'uae-villas'),
                            'study' => __('Study Room', 'uae-villas'),
                            'laundry' => __('Laundry Room', 'uae-villas'),
                            'storage' => __('Storage Room', 'uae-villas'),
                            'security' => __('24/7 Security', 'uae-villas'),
                            'concierge' => __('Concierge Service', 'uae-villas'),
                            'beach_access' => __('Beach Access', 'uae-villas'),
                            'golf_view' => __('Golf Course View', 'uae-villas'),
                            'sea_view' => __('Sea View', 'uae-villas'),
                            'city_view' => __('City View', 'uae-villas'),
                        );
                        
                        foreach ($amenities as $amenity) :
                            if (isset($amenity_labels[$amenity])) :
                        ?>
                            <div class="amenity-item">
                                <i class="fas fa-check"></i>
                                <span><?php echo esc_html($amenity_labels[$amenity]); ?></span>
                            </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Property Map -->
                <?php
                $map_embed = get_field('property_map_embed');
                if ($map_embed) :
                ?>
                <div class="property-map">
                    <h2><?php esc_html_e('Location', 'uae-villas'); ?></h2>
                    <div class="map-container">
                        <?php echo wp_kses_post($map_embed); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Property Sidebar -->
            <div class="property-sidebar">
                <!-- Contact Form -->
                <div class="property-contact-form">
                    <h3><?php esc_html_e('Inquire About This Property', 'uae-villas'); ?></h3>
                    <form class="inquiry-form" id="propertyInquiryForm">
                        <?php wp_nonce_field('property_inquiry', 'property_inquiry_nonce'); ?>
                        <input type="hidden" name="property_id" value="<?php echo get_the_ID(); ?>">
                        <input type="hidden" name="property_title" value="<?php echo esc_attr(get_the_title()); ?>">
                        
                        <div class="form-group">
                            <label for="inquiry_name"><?php esc_html_e('Full Name', 'uae-villas'); ?></label>
                            <input type="text" id="inquiry_name" name="inquiry_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="inquiry_email"><?php esc_html_e('Email Address', 'uae-villas'); ?></label>
                            <input type="email" id="inquiry_email" name="inquiry_email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="inquiry_phone"><?php esc_html_e('Phone Number', 'uae-villas'); ?></label>
                            <input type="tel" id="inquiry_phone" name="inquiry_phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="inquiry_message"><?php esc_html_e('Message', 'uae-villas'); ?></label>
                            <textarea id="inquiry_message" name="inquiry_message" rows="4" placeholder="<?php esc_attr_e('I am interested in this property...', 'uae-villas'); ?>"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-full">
                            <?php esc_html_e('Send Inquiry', 'uae-villas'); ?>
                        </button>
                    </form>
                </div>
                
                <!-- Schedule Consultation -->
                <div class="schedule-consultation">
                    <h3><?php esc_html_e('Schedule a Consultation', 'uae-villas'); ?></h3>
                    <p><?php esc_html_e('Book a personalized consultation to discuss this property and your requirements.', 'uae-villas'); ?></p>
                    <a href="<?php echo esc_url(get_theme_mod('calendly_url', 'https://calendly.com/your-account')); ?>" class="btn btn-outline btn-full" target="_blank">
                        <?php esc_html_e('Book Consultation', 'uae-villas'); ?>
                    </a>
                </div>
                
                <!-- Property Quick Facts -->
                <div class="property-quick-facts">
                    <h3><?php esc_html_e('Quick Facts', 'uae-villas'); ?></h3>
                    <ul class="facts-list">
                        <?php if (get_field('property_bedrooms')) : ?>
                            <li>
                                <strong><?php esc_html_e('Bedrooms:', 'uae-villas'); ?></strong>
                                <?php echo esc_html(get_field('property_bedrooms')); ?>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_field('property_bathrooms')) : ?>
                            <li>
                                <strong><?php esc_html_e('Bathrooms:', 'uae-villas'); ?></strong>
                                <?php echo esc_html(get_field('property_bathrooms')); ?>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (get_field('property_sqft')) : ?>
                            <li>
                                <strong><?php esc_html_e('Size:', 'uae-villas'); ?></strong>
                                <?php echo number_format(get_field('property_sqft')); ?> sq. ft.
                            </li>
                        <?php endif; ?>
                        
                        <?php
                        $property_type = get_the_terms(get_the_ID(), 'property_type');
                        if ($property_type && !is_wp_error($property_type)) :
                        ?>
                            <li>
                                <strong><?php esc_html_e('Type:', 'uae-villas'); ?></strong>
                                <?php echo esc_html($property_type[0]->name); ?>
                            </li>
                        <?php endif; ?>
                        
                        <li>
                            <strong><?php esc_html_e('Property ID:', 'uae-villas'); ?></strong>
                            <?php echo get_the_ID(); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Properties -->
<section class="related-properties">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('Similar Properties', 'uae-villas'); ?></h2>
        
        <?php
        $related_properties = new WP_Query(array(
            'post_type' => 'property',
            'posts_per_page' => 3,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'property_community',
                    'field'    => 'term_id',
                    'terms'    => wp_get_post_terms(get_the_ID(), 'property_community', array('fields' => 'ids')),
                ),
            ),
            'orderby' => 'rand',
        ));
        
        if ($related_properties->have_posts()) :
        ?>
            <div class="villa-grid">
                <?php
                while ($related_properties->have_posts()) : $related_properties->the_post();
                    get_template_part('template-parts/property-card');
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>


