<?php
/**
 * The template for displaying the footer
 *
 * @package UAE_Villas
 * @since 1.0.0
 */
?>

    </main><!-- #primary -->

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-nav" id="mobileNav">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-item <?php echo (is_front_page()) ? 'active' : ''; ?>" data-section="hero">
            <i class="fas fa-home"></i>
            <span><?php esc_html_e('Home', 'uae-villas'); ?></span>
        </a>
        <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="nav-item <?php echo (is_post_type_archive('property') || is_singular('property')) ? 'active' : ''; ?>" data-section="villas">
            <i class="fas fa-key"></i>
            <span><?php esc_html_e('Properties', 'uae-villas'); ?></span>
        </a>
        <a href="<?php echo esc_url(home_url('/#guides')); ?>" class="nav-item" data-section="guides">
            <i class="fas fa-book"></i>
            <span><?php esc_html_e('Guides', 'uae-villas'); ?></span>
        </a>
        <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="nav-item" data-section="contact">
            <i class="fas fa-phone"></i>
            <span><?php esc_html_e('Contact', 'uae-villas'); ?></span>
        </a>
    </nav>

    <footer id="colophon" class="site-footer">
        <?php if (is_active_sidebar('footer-widgets')) : ?>
        <div class="footer-widgets">
            <div class="container">
                <?php dynamic_sidebar('footer-widgets'); ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-info">
                    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'uae-villas'); ?></p>
                    <p><?php esc_html_e('Luxury real estate specialists in the UAE.', 'uae-villas'); ?></p>
                </div>
                
                <?php if (has_nav_menu('footer')) : ?>
                <nav class="footer-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                </nav>
                <?php endif; ?>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>


