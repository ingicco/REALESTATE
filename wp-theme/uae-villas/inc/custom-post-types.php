<?php
/**
 * Custom Post Types and Taxonomies
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Property Custom Post Type
 */
function uae_villas_register_property_post_type() {
    $labels = array(
        'name'                  => _x('Properties', 'Post type general name', 'uae-villas'),
        'singular_name'         => _x('Property', 'Post type singular name', 'uae-villas'),
        'menu_name'             => _x('Properties', 'Admin Menu text', 'uae-villas'),
        'name_admin_bar'        => _x('Property', 'Add New on Toolbar', 'uae-villas'),
        'add_new'               => __('Add New', 'uae-villas'),
        'add_new_item'          => __('Add New Property', 'uae-villas'),
        'new_item'              => __('New Property', 'uae-villas'),
        'edit_item'             => __('Edit Property', 'uae-villas'),
        'view_item'             => __('View Property', 'uae-villas'),
        'all_items'             => __('All Properties', 'uae-villas'),
        'search_items'          => __('Search Properties', 'uae-villas'),
        'parent_item_colon'     => __('Parent Properties:', 'uae-villas'),
        'not_found'             => __('No properties found.', 'uae-villas'),
        'not_found_in_trash'    => __('No properties found in Trash.', 'uae-villas'),
        'featured_image'        => _x('Property Featured Image', 'Overrides the "Featured Image" phrase', 'uae-villas'),
        'set_featured_image'    => _x('Set featured image', 'Overrides the "Set featured image" phrase', 'uae-villas'),
        'remove_featured_image' => _x('Remove featured image', 'Overrides the "Remove featured image" phrase', 'uae-villas'),
        'use_featured_image'    => _x('Use as featured image', 'Overrides the "Use as featured image" phrase', 'uae-villas'),
        'archives'              => _x('Property archives', 'The post type archive label', 'uae-villas'),
        'insert_into_item'      => _x('Insert into property', 'Overrides the "Insert into post" phrase', 'uae-villas'),
        'uploaded_to_this_item' => _x('Uploaded to this property', 'Overrides the "Uploaded to this post" phrase', 'uae-villas'),
        'filter_items_list'     => _x('Filter properties list', 'Screen reader text for the filter links', 'uae-villas'),
        'items_list_navigation' => _x('Properties list navigation', 'Screen reader text for the pagination', 'uae-villas'),
        'items_list'            => _x('Properties list', 'Screen reader text for the items list', 'uae-villas'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'properties'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-admin-home',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_customizer' => true,
    );

    register_post_type('property', $args);
}
add_action('init', 'uae_villas_register_property_post_type');

/**
 * Register Property Taxonomies
 */
function uae_villas_register_property_taxonomies() {
    // Property Community Taxonomy
    $community_labels = array(
        'name'              => _x('Communities', 'taxonomy general name', 'uae-villas'),
        'singular_name'     => _x('Community', 'taxonomy singular name', 'uae-villas'),
        'search_items'      => __('Search Communities', 'uae-villas'),
        'all_items'         => __('All Communities', 'uae-villas'),
        'parent_item'       => __('Parent Community', 'uae-villas'),
        'parent_item_colon' => __('Parent Community:', 'uae-villas'),
        'edit_item'         => __('Edit Community', 'uae-villas'),
        'update_item'       => __('Update Community', 'uae-villas'),
        'add_new_item'      => __('Add New Community', 'uae-villas'),
        'new_item_name'     => __('New Community Name', 'uae-villas'),
        'menu_name'         => __('Communities', 'uae-villas'),
    );

    $community_args = array(
        'hierarchical'      => true,
        'labels'            => $community_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'community'),
    );

    register_taxonomy('property_community', array('property'), $community_args);

    // Property Type Taxonomy
    $type_labels = array(
        'name'              => _x('Property Types', 'taxonomy general name', 'uae-villas'),
        'singular_name'     => _x('Property Type', 'taxonomy singular name', 'uae-villas'),
        'search_items'      => __('Search Property Types', 'uae-villas'),
        'all_items'         => __('All Property Types', 'uae-villas'),
        'edit_item'         => __('Edit Property Type', 'uae-villas'),
        'update_item'       => __('Update Property Type', 'uae-villas'),
        'add_new_item'      => __('Add New Property Type', 'uae-villas'),
        'new_item_name'     => __('New Property Type Name', 'uae-villas'),
        'menu_name'         => __('Property Types', 'uae-villas'),
    );

    $type_args = array(
        'hierarchical'      => false,
        'labels'            => $type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'property-type'),
    );

    register_taxonomy('property_type', array('property'), $type_args);
}
add_action('init', 'uae_villas_register_property_taxonomies');

/**
 * Add Custom Fields for Properties (using ACF if available, otherwise custom meta boxes)
 */
function uae_villas_add_property_meta_boxes() {
    // Only add meta boxes if ACF is not available
    if (!function_exists('acf_add_local_field_group')) {
        add_meta_box(
            'property_details',
            __('Property Details', 'uae-villas'),
            'uae_villas_property_details_callback',
            'property',
            'normal',
            'high'
        );
        
        add_meta_box(
            'property_amenities',
            __('Property Amenities', 'uae-villas'),
            'uae_villas_property_amenities_callback',
            'property',
            'side',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'uae_villas_add_property_meta_boxes');

/**
 * Property Details Meta Box Callback
 */
function uae_villas_property_details_callback($post) {
    wp_nonce_field('uae_villas_property_details', 'uae_villas_property_details_nonce');
    
    $price = get_post_meta($post->ID, '_property_price', true);
    $bedrooms = get_post_meta($post->ID, '_property_bedrooms', true);
    $bathrooms = get_post_meta($post->ID, '_property_bathrooms', true);
    $sqft = get_post_meta($post->ID, '_property_sqft', true);
    $featured = get_post_meta($post->ID, '_property_featured', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="property_price"><?php _e('Price (AED)', 'uae-villas'); ?></label></th>
            <td><input type="number" id="property_price" name="property_price" value="<?php echo esc_attr($price); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="property_bedrooms"><?php _e('Bedrooms', 'uae-villas'); ?></label></th>
            <td><input type="number" id="property_bedrooms" name="property_bedrooms" value="<?php echo esc_attr($bedrooms); ?>" min="1" max="20" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="property_bathrooms"><?php _e('Bathrooms', 'uae-villas'); ?></label></th>
            <td><input type="number" id="property_bathrooms" name="property_bathrooms" value="<?php echo esc_attr($bathrooms); ?>" min="1" max="20" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="property_sqft"><?php _e('Square Feet', 'uae-villas'); ?></label></th>
            <td><input type="number" id="property_sqft" name="property_sqft" value="<?php echo esc_attr($sqft); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th scope="row"><label for="property_featured"><?php _e('Featured Property', 'uae-villas'); ?></label></th>
            <td><input type="checkbox" id="property_featured" name="property_featured" value="1" <?php checked($featured, 1); ?> /></td>
        </tr>
    </table>
    <?php
}

/**
 * Property Amenities Meta Box Callback
 */
function uae_villas_property_amenities_callback($post) {
    $amenities = get_post_meta($post->ID, '_property_amenities', true);
    if (!is_array($amenities)) {
        $amenities = array();
    }
    
    $available_amenities = array(
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
    
    ?>
    <div class="property-amenities-checklist">
        <?php foreach ($available_amenities as $key => $label) : ?>
            <label>
                <input type="checkbox" name="property_amenities[]" value="<?php echo esc_attr($key); ?>" <?php checked(in_array($key, $amenities)); ?> />
                <?php echo esc_html($label); ?>
            </label><br>
        <?php endforeach; ?>
    </div>
    <?php
}

/**
 * Save Property Meta Data
 */
function uae_villas_save_property_meta($post_id) {
    // Check if our nonce is set and verify it
    if (!isset($_POST['uae_villas_property_details_nonce']) || 
        !wp_verify_nonce($_POST['uae_villas_property_details_nonce'], 'uae_villas_property_details')) {
        return;
    }

    // If this is an autosave, don't do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save the data
    $fields = array('property_price', 'property_bedrooms', 'property_bathrooms', 'property_sqft');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
    
    // Handle featured checkbox
    $featured = isset($_POST['property_featured']) ? 1 : 0;
    update_post_meta($post_id, '_property_featured', $featured);
    
    // Handle amenities
    $amenities = isset($_POST['property_amenities']) ? $_POST['property_amenities'] : array();
    update_post_meta($post_id, '_property_amenities', array_map('sanitize_text_field', $amenities));
}
add_action('save_post', 'uae_villas_save_property_meta');

/**
 * Add ACF Field Groups (if ACF is available)
 */
function uae_villas_add_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_property_details',
        'title' => 'Property Details',
        'fields' => array(
            array(
                'key' => 'field_property_price',
                'label' => 'Price (AED)',
                'name' => 'property_price',
                'type' => 'number',
                'required' => 1,
                'min' => 1,
            ),
            array(
                'key' => 'field_property_bedrooms',
                'label' => 'Bedrooms',
                'name' => 'property_bedrooms',
                'type' => 'number',
                'required' => 1,
                'min' => 1,
                'max' => 20,
            ),
            array(
                'key' => 'field_property_bathrooms',
                'label' => 'Bathrooms',
                'name' => 'property_bathrooms',
                'type' => 'number',
                'required' => 1,
                'min' => 1,
                'max' => 20,
            ),
            array(
                'key' => 'field_property_sqft',
                'label' => 'Square Feet',
                'name' => 'property_sqft',
                'type' => 'number',
                'required' => 1,
                'min' => 1,
            ),
            array(
                'key' => 'field_property_gallery',
                'label' => 'Property Gallery',
                'name' => 'property_gallery',
                'type' => 'gallery',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_property_amenities',
                'label' => 'Amenities',
                'name' => 'property_amenities',
                'type' => 'checkbox',
                'choices' => array(
                    'pool' => 'Swimming Pool',
                    'gym' => 'Gym/Fitness Center',
                    'garden' => 'Garden',
                    'garage' => 'Garage',
                    'balcony' => 'Balcony/Terrace',
                    'maid_room' => 'Maid\'s Room',
                    'study' => 'Study Room',
                    'laundry' => 'Laundry Room',
                    'storage' => 'Storage Room',
                    'security' => '24/7 Security',
                    'concierge' => 'Concierge Service',
                    'beach_access' => 'Beach Access',
                    'golf_view' => 'Golf Course View',
                    'sea_view' => 'Sea View',
                    'city_view' => 'City View',
                ),
                'layout' => 'vertical',
            ),
            array(
                'key' => 'field_property_featured',
                'label' => 'Featured Property',
                'name' => 'property_featured',
                'type' => 'true_false',
                'ui' => 1,
            ),
            array(
                'key' => 'field_property_map_embed',
                'label' => 'Map Embed Code',
                'name' => 'property_map_embed',
                'type' => 'textarea',
                'instructions' => 'Paste Google Maps embed code here',
            ),
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
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}
add_action('acf/init', 'uae_villas_add_acf_fields');

/**
 * Flush rewrite rules on theme activation
 */
function uae_villas_flush_rewrite_rules() {
    uae_villas_register_property_post_type();
    uae_villas_register_property_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'uae_villas_flush_rewrite_rules');
?>


