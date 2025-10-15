<?php
/**
 * Template Functions
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Format property price
 */
function uae_villas_format_price($price) {
    if (!$price) {
        return '';
    }
    
    return 'AED ' . number_format($price);
}

/**
 * Get property features/amenities
 */
function uae_villas_get_property_amenities($property_id = null) {
    if (!$property_id) {
        $property_id = get_the_ID();
    }
    
    $amenities = get_field('property_amenities', $property_id);
    
    if (!$amenities || !is_array($amenities)) {
        return array();
    }
    
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
    
    $formatted_amenities = array();
    
    foreach ($amenities as $amenity) {
        if (isset($amenity_labels[$amenity])) {
            $formatted_amenities[] = $amenity_labels[$amenity];
        }
    }
    
    return $formatted_amenities;
}

/**
 * Get property community name
 */
function uae_villas_get_property_community($property_id = null) {
    if (!$property_id) {
        $property_id = get_the_ID();
    }
    
    $communities = get_the_terms($property_id, 'property_community');
    
    if ($communities && !is_wp_error($communities)) {
        return $communities[0]->name;
    }
    
    return '';
}

/**
 * Get property specifications as formatted string
 */
function uae_villas_get_property_specs($property_id = null) {
    if (!$property_id) {
        $property_id = get_the_ID();
    }
    
    $bedrooms = get_field('property_bedrooms', $property_id);
    $bathrooms = get_field('property_bathrooms', $property_id);
    $sqft = get_field('property_sqft', $property_id);
    
    $specs = array();
    
    if ($bedrooms) {
        $specs[] = sprintf(esc_html__('%d Beds', 'uae-villas'), $bedrooms);
    }
    
    if ($bathrooms) {
        $specs[] = sprintf(esc_html__('%d Baths', 'uae-villas'), $bathrooms);
    }
    
    if ($sqft) {
        $specs[] = number_format($sqft) . ' sq. ft.';
    }
    
    return implode(' | ', $specs);
}

/**
 * Check if property is featured
 */
function uae_villas_is_featured_property($property_id = null) {
    if (!$property_id) {
        $property_id = get_the_ID();
    }
    
    return get_field('property_featured', $property_id) ? true : false;
}

/**
 * Get property gallery images
 */
function uae_villas_get_property_gallery($property_id = null) {
    if (!$property_id) {
        $property_id = get_the_ID();
    }
    
    $gallery = get_field('property_gallery', $property_id);
    
    if ($gallery && is_array($gallery)) {
        return $gallery;
    }
    
    return array();
}

/**
 * Generate property card HTML
 */
function uae_villas_property_card($property_id) {
    $property = get_post($property_id);
    
    if (!$property || $property->post_type !== 'property') {
        return '';
    }
    
    setup_postdata($property);
    
    ob_start();
    get_template_part('template-parts/property-card');
    $output = ob_get_clean();
    
    wp_reset_postdata();
    
    return $output;
}

/**
 * Get blog post excerpt with custom length
 */
function uae_villas_get_excerpt($post_id = null, $length = 25) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post = get_post($post_id);
    
    if (!$post) {
        return '';
    }
    
    if ($post->post_excerpt) {
        return $post->post_excerpt;
    }
    
    $content = strip_tags($post->post_content);
    $words = explode(' ', $content);
    
    if (count($words) > $length) {
        $words = array_slice($words, 0, $length);
        return implode(' ', $words) . '...';
    }
    
    return $content;
}

/**
 * Get reading time for blog posts
 */
function uae_villas_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post = get_post($post_id);
    
    if (!$post) {
        return '';
    }
    
    $word_count = str_word_count(strip_tags($post->post_content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    if ($reading_time < 1) {
        $reading_time = 1;
    }
    
    return sprintf(esc_html__('%d min read', 'uae-villas'), $reading_time);
}

/**
 * Get social sharing links
 */
function uae_villas_get_social_share_links($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_url = get_permalink($post_id);
    $post_title = get_the_title($post_id);
    
    $links = array(
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($post_url),
        'twitter' => 'https://twitter.com/intent/tweet?url=' . urlencode($post_url) . '&text=' . urlencode($post_title),
        'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($post_url),
        'whatsapp' => 'https://wa.me/?text=' . urlencode($post_title . ' ' . $post_url),
    );
    
    return $links;
}

/**
 * Custom pagination for property archive
 */
function uae_villas_property_pagination() {
    global $wp_query;
    
    $big = 999999999; // need an unlikely integer
    
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'uae-villas'),
        'next_text' => __('Next', 'uae-villas') . ' <i class="fas fa-chevron-right"></i>',
        'mid_size' => 2,
        'type' => 'array'
    ));
    
    if ($pagination) {
        echo '<nav class="pagination">';
        foreach ($pagination as $page) {
            echo $page;
        }
        echo '</nav>';
    }
}

/**
 * Get property search form
 */
function uae_villas_property_search_form() {
    ob_start();
    ?>
    <form class="property-search-form" method="GET" action="<?php echo esc_url(get_post_type_archive_link('property')); ?>">
        <div class="search-fields">
            <input type="text" name="search_keyword" placeholder="<?php esc_attr_e('Search properties...', 'uae-villas'); ?>" value="<?php echo esc_attr(get_query_var('search_keyword')); ?>">
            
            <select name="property_community">
                <option value=""><?php esc_html_e('All Communities', 'uae-villas'); ?></option>
                <?php
                $communities = get_terms(array(
                    'taxonomy' => 'property_community',
                    'hide_empty' => true,
                ));
                
                foreach ($communities as $community) :
                    $selected = (get_query_var('property_community') === $community->slug) ? 'selected' : '';
                    ?>
                    <option value="<?php echo esc_attr($community->slug); ?>" <?php echo $selected; ?>>
                        <?php echo esc_html($community->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                <?php esc_html_e('Search', 'uae-villas'); ?>
            </button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

/**
 * Breadcrumb navigation
 */
function uae_villas_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    echo '<nav class="breadcrumbs">';
    echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'uae-villas') . '</a>';
    
    if (is_post_type_archive('property')) {
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . esc_html__('Properties', 'uae-villas') . '</span>';
    } elseif (is_singular('property')) {
        echo ' <span class="separator">/</span> ';
        echo '<a href="' . esc_url(get_post_type_archive_link('property')) . '">' . esc_html__('Properties', 'uae-villas') . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif (is_home()) {
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . esc_html__('Blog', 'uae-villas') . '</span>';
    } elseif (is_single()) {
        echo ' <span class="separator">/</span> ';
        echo '<a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">' . esc_html__('Blog', 'uae-villas') . '</a>';
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    } elseif (is_page()) {
        echo ' <span class="separator">/</span> ';
        echo '<span class="current">' . get_the_title() . '</span>';
    }
    
    echo '</nav>';
}

/**
 * Get theme option with fallback
 */
function uae_villas_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

/**
 * Check if ACF is active
 */
function uae_villas_is_acf_active() {
    return function_exists('get_field');
}

/**
 * Fallback function for get_field if ACF is not active
 */
if (!function_exists('get_field')) {
    function get_field($field_name, $post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        
        return get_post_meta($post_id, '_' . $field_name, true);
    }
}
?>


