<?php
/**
 * Template part for displaying property cards
 *
 * @package UAE_Villas
 * @since 1.0.0
 */
?>

<div class="property-card villa-card" data-property-id="<?php echo get_the_ID(); ?>">
    <div class="property-image villa-image">
        <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('property-card'); ?>
            </a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>">
                <div class="property-placeholder">
                    <i class="fas fa-home"></i>
                </div>
            </a>
        <?php endif; ?>
        
        <?php if (get_field('property_featured')) : ?>
            <div class="property-badge">
                <?php esc_html_e('Featured', 'uae-villas'); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="property-info villa-info">
        <div class="property-location">
            <?php
            $communities = get_the_terms(get_the_ID(), 'property_community');
            if ($communities && !is_wp_error($communities)) {
                echo esc_html($communities[0]->name);
            }
            ?>
        </div>
        
        <h3 class="property-title villa-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <p class="property-details villa-details">
            <?php
            $bedrooms = get_field('property_bedrooms');
            $bathrooms = get_field('property_bathrooms');
            $sqft = get_field('property_sqft');
            
            $details = array();
            
            if ($bedrooms) {
                $details[] = sprintf(esc_html__('%d Beds', 'uae-villas'), $bedrooms);
            }
            
            if ($bathrooms) {
                $details[] = sprintf(esc_html__('%d Baths', 'uae-villas'), $bathrooms);
            }
            
            if ($sqft) {
                $details[] = number_format($sqft) . ' sq. ft.';
            }
            
            echo implode(' | ', $details);
            ?>
        </p>
        
        <?php
        $amenities = get_field('property_amenities');
        if ($amenities && is_array($amenities)) :
            $amenity_labels = array(
                'pool' => __('Pool', 'uae-villas'),
                'gym' => __('Gym', 'uae-villas'),
                'garden' => __('Garden', 'uae-villas'),
                'garage' => __('Garage', 'uae-villas'),
                'balcony' => __('Balcony', 'uae-villas'),
                'maid_room' => __('Maid\'s Room', 'uae-villas'),
                'study' => __('Study', 'uae-villas'),
                'laundry' => __('Laundry', 'uae-villas'),
                'storage' => __('Storage', 'uae-villas'),
                'security' => __('Security', 'uae-villas'),
                'concierge' => __('Concierge', 'uae-villas'),
                'beach_access' => __('Beach Access', 'uae-villas'),
                'golf_view' => __('Golf View', 'uae-villas'),
                'sea_view' => __('Sea View', 'uae-villas'),
                'city_view' => __('City View', 'uae-villas'),
            );
            
            $displayed_amenities = array();
            foreach (array_slice($amenities, 0, 3) as $amenity) {
                if (isset($amenity_labels[$amenity])) {
                    $displayed_amenities[] = $amenity_labels[$amenity];
                }
            }
            
            if (!empty($displayed_amenities)) :
        ?>
            <div class="property-features">
                <?php foreach ($displayed_amenities as $amenity) : ?>
                    <span><i class="fas fa-check"></i> <?php echo esc_html($amenity); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; endif; ?>
        
        <p class="property-price villa-price">
            <?php
            $price = get_field('property_price');
            if ($price) {
                echo 'AED ' . number_format($price);
            }
            ?>
        </p>
        
        <div class="property-actions">
            <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-small">
                <?php esc_html_e('View Details', 'uae-villas'); ?>
            </a>
            <button class="btn btn-primary btn-small contact-btn" data-property-id="<?php echo get_the_ID(); ?>" data-property-title="<?php echo esc_attr(get_the_title()); ?>">
                <?php esc_html_e('Contact Agent', 'uae-villas'); ?>
            </button>
        </div>
    </div>
</div>


