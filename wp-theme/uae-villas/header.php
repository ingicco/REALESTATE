<?php
/**
 * The header for our theme
 *
 * @package UAE_Villas
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'uae-villas'); ?></a>

    <?php if (!is_front_page() && !is_home()) : ?>
    <!-- Desktop Header Navigation (for non-homepage pages) -->
    <header class="desktop-header">
        <div class="container">
            <nav class="header-nav">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                if ($custom_logo_id) :
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                        <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>">
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><?php bloginfo('name'); ?></a>
                <?php endif; ?>
                
                <div class="nav-links">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => 'uae_villas_default_menu',
                    ));
                    ?>
                </div>
            </nav>
        </div>
    </header>
    <?php endif; ?>

    <main id="primary" class="site-main"><?php
/**
 * Default menu fallback
 */
function uae_villas_default_menu() {
    ?>
    <ul id="primary-menu" class="nav-menu">
        <li class="<?php echo (is_front_page()) ? 'current-menu-item' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
        </li>
        <li class="<?php echo (is_post_type_archive('property') || is_singular('property')) ? 'current-menu-item' : ''; ?>">
            <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>">Properties</a>
        </li>
        <li class="<?php echo (is_home() || is_category() || is_single()) ? 'current-menu-item' : ''; ?>">
            <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Blog</a>
        </li>
        <li>
            <a href="<?php echo esc_url(home_url('/#guides')); ?>">Guides</a>
        </li>
        <li>
            <a href="<?php echo esc_url(home_url('/#contact')); ?>">Contact</a>
        </li>
    </ul>
    <?php
}
?>


