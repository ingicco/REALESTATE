<?php
/**
 * The template for displaying the blog archive
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

get_header(); ?>

<!-- Blog Header -->
<section class="blog-header">
    <div class="container">
        <h1 class="page-title"><?php echo esc_html(get_theme_mod('blog_page_title', 'Real Estate Insights & News')); ?></h1>
        <p class="page-subtitle"><?php echo esc_html(get_theme_mod('blog_page_subtitle', 'Stay informed with the latest trends, market insights, and expert advice on UAE real estate.')); ?></p>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-content">
    <div class="container">
        <div class="blog-layout">
            <main class="blog-main">
                <?php if (have_posts()) : ?>
                    <div class="blog-posts">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/blog-card');
                        endwhile;
                        ?>
                    </div>
                    
                    <!-- Blog Pagination -->
                    <div class="blog-pagination">
                        <?php
                        $pagination_args = array(
                            'mid_size'  => 2,
                            'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'uae-villas'),
                            'next_text' => __('Next', 'uae-villas') . ' <i class="fas fa-chevron-right"></i>',
                        );
                        
                        echo paginate_links($pagination_args);
                        ?>
                    </div>
                    
                <?php else : ?>
                    <div class="no-posts">
                        <h2><?php esc_html_e('No posts found', 'uae-villas'); ?></h2>
                        <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'uae-villas'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </main>
            
            <aside class="blog-sidebar">
                <?php if (is_active_sidebar('blog-sidebar')) : ?>
                    <?php dynamic_sidebar('blog-sidebar'); ?>
                <?php else : ?>
                    <!-- Default sidebar content -->
                    <div class="widget">
                        <h3 class="widget-title"><?php esc_html_e('Categories', 'uae-villas'); ?></h3>
                        <ul>
                            <?php wp_list_categories(array('title_li' => '')); ?>
                        </ul>
                    </div>
                    
                    <div class="widget">
                        <h3 class="widget-title"><?php esc_html_e('Recent Posts', 'uae-villas'); ?></h3>
                        <ul>
                            <?php
                            $recent_posts = wp_get_recent_posts(array(
                                'numberposts' => 5,
                                'post_status' => 'publish'
                            ));
                            
                            foreach ($recent_posts as $post) :
                            ?>
                                <li>
                                    <a href="<?php echo get_permalink($post['ID']); ?>">
                                        <?php echo esc_html($post['post_title']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="widget">
                        <h3 class="widget-title"><?php esc_html_e('Search', 'uae-villas'); ?></h3>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?php get_footer(); ?>


