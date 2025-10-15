<?php
/**
 * AJAX Handlers
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Property Inquiry Form Submission
 */
function uae_villas_handle_property_inquiry() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['property_inquiry_nonce'], 'property_inquiry')) {
        wp_die(__('Security check failed', 'uae-villas'));
    }
    
    // Sanitize form data
    $property_id = intval($_POST['property_id']);
    $property_title = sanitize_text_field($_POST['property_title']);
    $name = sanitize_text_field($_POST['inquiry_name']);
    $email = sanitize_email($_POST['inquiry_email']);
    $phone = sanitize_text_field($_POST['inquiry_phone']);
    $message = sanitize_textarea_field($_POST['inquiry_message']);
    
    // Validate required fields
    if (empty($name) || empty($email) || !is_email($email)) {
        wp_send_json_error(__('Please fill in all required fields with valid information.', 'uae-villas'));
    }
    
    // Prepare email content
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    $subject = sprintf(__('Property Inquiry: %s', 'uae-villas'), $property_title);
    
    $email_message = sprintf(
        __("New property inquiry received:\n\nProperty: %s (ID: %d)\nName: %s\nEmail: %s\nPhone: %s\n\nMessage:\n%s\n\nProperty URL: %s", 'uae-villas'),
        $property_title,
        $property_id,
        $name,
        $email,
        $phone,
        $message,
        get_permalink($property_id)
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Send email
    $sent = wp_mail($admin_email, $subject, $email_message, $headers);
    
    if ($sent) {
        // Store inquiry in database (optional)
        $inquiry_data = array(
            'property_id' => $property_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'date_submitted' => current_time('mysql')
        );
        
        // You can save this to a custom table or as post meta
        // For now, we'll just send success response
        
        wp_send_json_success(__('Thank you for your inquiry! We will contact you shortly.', 'uae-villas'));
    } else {
        wp_send_json_error(__('Sorry, there was an error sending your message. Please try again.', 'uae-villas'));
    }
}
add_action('wp_ajax_property_inquiry', 'uae_villas_handle_property_inquiry');
add_action('wp_ajax_nopriv_property_inquiry', 'uae_villas_handle_property_inquiry');

/**
 * Handle Guide Download Form Submission
 */
function uae_villas_handle_guide_download() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['guide_nonce'], 'uae_villas_nonce')) {
        wp_die(__('Security check failed', 'uae-villas'));
    }
    
    // Sanitize form data
    $first_name = sanitize_text_field($_POST['firstName']);
    $email = sanitize_email($_POST['email']);
    
    // Validate required fields
    if (empty($first_name) || empty($email) || !is_email($email)) {
        wp_send_json_error(__('Please fill in all fields with valid information.', 'uae-villas'));
    }
    
    // Add to mailing list (you can integrate with MailChimp, ConvertKit, etc.)
    // For now, we'll just send an email
    
    $admin_email = get_option('admin_email');
    $site_name = get_bloginfo('name');
    
    $subject = __('New Guide Download Request', 'uae-villas');
    
    $email_message = sprintf(
        __("New guide download request:\n\nName: %s\nEmail: %s\nDate: %s", 'uae-villas'),
        $first_name,
        $email,
        current_time('Y-m-d H:i:s')
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $site_name . ' <' . $admin_email . '>'
    );
    
    // Send notification to admin
    wp_mail($admin_email, $subject, $email_message, $headers);
    
    // Send guide to user (you would attach the actual PDF here)
    $user_subject = sprintf(__('Your UAE Relocation Guide from %s', 'uae-villas'), $site_name);
    $user_message = sprintf(
        __("Hi %s,\n\nThank you for downloading our UAE Relocation Guide!\n\nYou can download your guide here: [GUIDE_DOWNLOAD_LINK]\n\nIf you have any questions, feel free to contact us.\n\nBest regards,\nThe %s Team", 'uae-villas'),
        $first_name,
        $site_name
    );
    
    wp_mail($email, $user_subject, $user_message, $headers);
    
    wp_send_json_success(sprintf(__('Thank you, %s! Your guide will be sent to %s shortly.', 'uae-villas'), $first_name, $email));
}
add_action('wp_ajax_guide_download', 'uae_villas_handle_guide_download');
add_action('wp_ajax_nopriv_guide_download', 'uae_villas_handle_guide_download');

/**
 * Handle Property Search/Filter AJAX
 */
function uae_villas_filter_properties() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'uae_villas_nonce')) {
        wp_die(__('Security check failed', 'uae-villas'));
    }
    
    // Get filter parameters
    $search_keyword = sanitize_text_field($_POST['search_keyword']);
    $community = sanitize_text_field($_POST['community']);
    $min_bedrooms = intval($_POST['min_bedrooms']);
    $price_range = sanitize_text_field($_POST['price_range']);
    $orderby = sanitize_text_field($_POST['orderby']);
    $paged = intval($_POST['paged']) ?: 1;
    
    // Build query arguments
    $args = array(
        'post_type' => 'property',
        'posts_per_page' => 9,
        'paged' => $paged,
        'post_status' => 'publish'
    );
    
    // Meta query for property details
    $meta_query = array('relation' => 'AND');
    
    if ($min_bedrooms) {
        $meta_query[] = array(
            'key' => 'property_bedrooms',
            'value' => $min_bedrooms,
            'compare' => '>='
        );
    }
    
    if ($price_range) {
        $price_parts = explode('-', $price_range);
        if (count($price_parts) == 2) {
            $min_price = intval($price_parts[0]);
            $max_price = intval($price_parts[1]);
            
            $meta_query[] = array(
                'key' => 'property_price',
                'value' => array($min_price, $max_price),
                'type' => 'NUMERIC',
                'compare' => 'BETWEEN'
            );
        }
    }
    
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }
    
    // Tax query for community
    if ($community) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'property_community',
                'field' => 'slug',
                'terms' => $community
            )
        );
    }
    
    // Search query
    if ($search_keyword) {
        $args['s'] = $search_keyword;
    }
    
    // Ordering
    switch ($orderby) {
        case 'price_low':
            $args['meta_key'] = 'property_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'price_high':
            $args['meta_key'] = 'property_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'bedrooms':
            $args['meta_key'] = 'property_bedrooms';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'date':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'featured':
        default:
            $args['meta_key'] = 'property_featured';
            $args['orderby'] = array(
                'meta_value_num' => 'DESC',
                'date' => 'DESC'
            );
            break;
    }
    
    // Execute query
    $properties_query = new WP_Query($args);
    
    $response = array(
        'properties' => array(),
        'pagination' => array(),
        'total' => $properties_query->found_posts
    );
    
    if ($properties_query->have_posts()) {
        while ($properties_query->have_posts()) {
            $properties_query->the_post();
            
            // Get property data
            $property_data = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'property-card'),
                'location' => '',
                'bedrooms' => get_field('property_bedrooms'),
                'bathrooms' => get_field('property_bathrooms'),
                'sqft' => get_field('property_sqft'),
                'price' => get_field('property_price'),
                'featured' => get_field('property_featured'),
                'amenities' => get_field('property_amenities')
            );
            
            // Get community
            $communities = get_the_terms(get_the_ID(), 'property_community');
            if ($communities && !is_wp_error($communities)) {
                $property_data['location'] = $communities[0]->name;
            }
            
            $response['properties'][] = $property_data;
        }
        
        // Pagination data
        $response['pagination'] = array(
            'current_page' => $paged,
            'max_pages' => $properties_query->max_num_pages,
            'total_posts' => $properties_query->found_posts
        );
    }
    
    wp_reset_postdata();
    
    wp_send_json_success($response);
}
add_action('wp_ajax_filter_properties', 'uae_villas_filter_properties');
add_action('wp_ajax_nopriv_filter_properties', 'uae_villas_filter_properties');

/**
 * Handle Quick Contact Form (for property cards)
 */
function uae_villas_quick_contact() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'uae_villas_nonce')) {
        wp_die(__('Security check failed', 'uae-villas'));
    }
    
    $property_id = intval($_POST['property_id']);
    $property_title = sanitize_text_field($_POST['property_title']);
    
    // In a real implementation, you might show a modal form
    // For now, we'll just redirect to the property page
    $property_url = get_permalink($property_id);
    
    wp_send_json_success(array(
        'message' => __('Redirecting to property details...', 'uae-villas'),
        'redirect' => $property_url
    ));
}
add_action('wp_ajax_quick_contact', 'uae_villas_quick_contact');
add_action('wp_ajax_nopriv_quick_contact', 'uae_villas_quick_contact');
?>


