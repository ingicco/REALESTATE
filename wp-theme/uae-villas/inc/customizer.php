<?php
/**
 * Theme Customizer
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function uae_villas_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'uae_villas_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'uae_villas_customize_partial_blogdescription',
            )
        );
    }

    // Hero Section
    $wp_customize->add_section('uae_villas_hero', array(
        'title'    => __('Hero Section', 'uae-villas'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default'           => 'From Relocation to Residence: Your Trusted Partner in Finding Your Dream UAE Villa',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'uae-villas'),
        'section' => 'uae_villas_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'We specialize in making your international move seamless, providing expert guidance on Dubai\'s exclusive villa communities, Golden Visas, and family life.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Subtitle', 'uae-villas'),
        'section' => 'uae_villas_hero',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('hero_video_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('hero_video_url', array(
        'label'   => __('Hero Video URL', 'uae-villas'),
        'section' => 'uae_villas_hero',
        'type'    => 'url',
    ));

    // Value Proposition Section
    $wp_customize->add_section('uae_villas_values', array(
        'title'    => __('Value Proposition', 'uae-villas'),
        'priority' => 35,
    ));

    // Value 1
    $wp_customize->add_setting('value_1_title', array(
        'default'           => 'Community Matching',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('value_1_title', array(
        'label'   => __('Value 1 Title', 'uae-villas'),
        'section' => 'uae_villas_values',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('value_1_description', array(
        'default'           => 'We don\'t just find a property; we find your place. Our deep knowledge of Dubai\'s neighborhoods ensures the perfect fit for your lifestyle.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('value_1_description', array(
        'label'   => __('Value 1 Description', 'uae-villas'),
        'section' => 'uae_villas_values',
        'type'    => 'textarea',
    ));

    // Value 2
    $wp_customize->add_setting('value_2_title', array(
        'default'           => 'Effortless Process',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('value_2_title', array(
        'label'   => __('Value 2 Title', 'uae-villas'),
        'section' => 'uae_villas_values',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('value_2_description', array(
        'default'           => 'From virtual viewings to legal paperwork, we manage every detail. Your international move becomes a seamless, stress-free experience.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('value_2_description', array(
        'label'   => __('Value 2 Description', 'uae-villas'),
        'section' => 'uae_villas_values',
        'type'    => 'textarea',
    ));

    // Value 3
    $wp_customize->add_setting('value_3_title', array(
        'default'           => 'Investment Intelligence',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('value_3_title', array(
        'label'   => __('Value 3 Title', 'uae-villas'),
        'section' => 'uae_villas_values',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('value_3_description', array(
        'default'           => 'Find a beautiful home that is also a sound financial investment. We provide market insights to maximize your property\'s potential.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('value_3_description', array(
        'label'   => __('Value 3 Description', 'uae-villas'),
        'section' => 'uae_villas_values',
        'type'    => 'textarea',
    ));

    // Lead Magnet Section
    $wp_customize->add_section('uae_villas_lead_magnet', array(
        'title'    => __('Lead Magnet', 'uae-villas'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('guide_title', array(
        'default'           => 'Your Essential Guide to a Successful Move',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('guide_title', array(
        'label'   => __('Guide Title', 'uae-villas'),
        'section' => 'uae_villas_lead_magnet',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('guide_description', array(
        'default'           => 'Our complimentary 2025 Relocation Guide covers the entire buying process, visa requirements, school systems, and associated costs.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('guide_description', array(
        'label'   => __('Guide Description', 'uae-villas'),
        'section' => 'uae_villas_lead_magnet',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('guide_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'guide_image', array(
        'label'   => __('Guide Image', 'uae-villas'),
        'section' => 'uae_villas_lead_magnet',
    )));

    // Testimonial Section
    $wp_customize->add_section('uae_villas_testimonial', array(
        'title'    => __('Testimonial', 'uae-villas'),
        'priority' => 45,
    ));

    $wp_customize->add_setting('testimonial_quote', array(
        'default'           => 'Moving our family from London was a monumental task. Their team found us a home in Dubai Hills that exceeded all expectations. The process was transparent and remarkably smooth.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('testimonial_quote', array(
        'label'   => __('Testimonial Quote', 'uae-villas'),
        'section' => 'uae_villas_testimonial',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('testimonial_attribution', array(
        'default'           => 'The Henderson Family, from London, UK',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('testimonial_attribution', array(
        'label'   => __('Testimonial Attribution', 'uae-villas'),
        'section' => 'uae_villas_testimonial',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('testimonial_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'testimonial_image', array(
        'label'   => __('Testimonial Image', 'uae-villas'),
        'section' => 'uae_villas_testimonial',
    )));

    // Final CTA Section
    $wp_customize->add_section('uae_villas_final_cta', array(
        'title'    => __('Final Call to Action', 'uae-villas'),
        'priority' => 50,
    ));

    $wp_customize->add_setting('final_cta_title', array(
        'default'           => 'Ready to Begin Your Journey?',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('final_cta_title', array(
        'label'   => __('Final CTA Title', 'uae-villas'),
        'section' => 'uae_villas_final_cta',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('final_cta_subtitle', array(
        'default'           => 'Schedule a no-obligation discovery call to discuss your ambitions.',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('final_cta_subtitle', array(
        'label'   => __('Final CTA Subtitle', 'uae-villas'),
        'section' => 'uae_villas_final_cta',
        'type'    => 'text',
    ));

    // Scheduling Integration
    $wp_customize->add_section('uae_villas_scheduling', array(
        'title'    => __('Scheduling Integration', 'uae-villas'),
        'priority' => 55,
    ));

    $wp_customize->add_setting('calendly_url', array(
        'default'           => 'https://calendly.com/your-account',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('calendly_url', array(
        'label'       => __('Calendly URL', 'uae-villas'),
        'description' => __('Enter your Calendly scheduling URL. This will be used for all "Book a Consultation" buttons.', 'uae-villas'),
        'section'     => 'uae_villas_scheduling',
        'type'        => 'url',
    ));

    // Properties Page Settings
    $wp_customize->add_section('uae_villas_properties_page', array(
        'title'    => __('Properties Page', 'uae-villas'),
        'priority' => 60,
    ));

    $wp_customize->add_setting('properties_page_title', array(
        'default'           => 'Discover Your Ideal Villa in the UAE',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('properties_page_title', array(
        'label'   => __('Properties Page Title', 'uae-villas'),
        'section' => 'uae_villas_properties_page',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('properties_page_subtitle', array(
        'default'           => 'Use the filters below to search our complete portfolio of luxury properties across Dubai\'s most exclusive communities.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('properties_page_subtitle', array(
        'label'   => __('Properties Page Subtitle', 'uae-villas'),
        'section' => 'uae_villas_properties_page',
        'type'    => 'textarea',
    ));

    // Blog Page Settings
    $wp_customize->add_section('uae_villas_blog_page', array(
        'title'    => __('Blog Page', 'uae-villas'),
        'priority' => 65,
    ));

    $wp_customize->add_setting('blog_page_title', array(
        'default'           => 'Real Estate Insights & News',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('blog_page_title', array(
        'label'   => __('Blog Page Title', 'uae-villas'),
        'section' => 'uae_villas_blog_page',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('blog_page_subtitle', array(
        'default'           => 'Stay informed with the latest trends, market insights, and expert advice on UAE real estate.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('blog_page_subtitle', array(
        'label'   => __('Blog Page Subtitle', 'uae-villas'),
        'section' => 'uae_villas_blog_page',
        'type'    => 'textarea',
    ));
}
add_action('customize_register', 'uae_villas_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function uae_villas_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function uae_villas_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function uae_villas_customize_preview_js() {
    wp_enqueue_script('uae-villas-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), UAE_VILLAS_VERSION, true);
}
add_action('customize_preview_init', 'uae_villas_customize_preview_js');
?>


