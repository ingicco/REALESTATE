<?php
/**
 * The template for displaying single blog posts
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<!-- Blog Post Header -->
<section class="blog-post-header">
    <div class="container">
        <div class="post-meta">
            <span class="post-date">
                <i class="fas fa-calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
            
            <span class="post-category">
                <i class="fas fa-folder"></i>
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo esc_html($categories[0]->name);
                }
                ?>
            </span>
            
            <span class="post-author">
                <i class="fas fa-user"></i>
                <?php echo get_the_author(); ?>
            </span>
        </div>
        
        <h1 class="post-title"><?php the_title(); ?></h1>
        
        <?php if (has_excerpt()) : ?>
            <div class="post-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Featured Image -->
<?php if (has_post_thumbnail()) : ?>
<section class="blog-post-featured-image">
    <div class="container">
        <div class="featured-image-container">
            <?php the_post_thumbnail('large'); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Blog Post Content -->
<section class="blog-post-content">
    <div class="container">
        <div class="blog-layout">
            <main class="blog-main">
                <article class="post-article">
                    <div class="post-content">
                        <?php the_content(); ?>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'uae-villas'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                    
                    <!-- Post Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                        <div class="post-tags">
                            <h4><?php esc_html_e('Tags:', 'uae-villas'); ?></h4>
                            <div class="tags-list">
                                <?php foreach ($tags as $tag) : ?>
                                    <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag-link">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Post Navigation -->
                    <div class="post-navigation">
                        <div class="nav-previous">
                            <?php
                            $prev_post = get_previous_post();
                            if ($prev_post) :
                            ?>
                                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                    <i class="fas fa-chevron-left"></i>
                                    <div class="nav-content">
                                        <span class="nav-label"><?php esc_html_e('Previous Post', 'uae-villas'); ?></span>
                                        <span class="nav-title"><?php echo esc_html($prev_post->post_title); ?></span>
                                    </div>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="nav-next">
                            <?php
                            $next_post = get_next_post();
                            if ($next_post) :
                            ?>
                                <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                    <div class="nav-content">
                                        <span class="nav-label"><?php esc_html_e('Next Post', 'uae-villas'); ?></span>
                                        <span class="nav-title"><?php echo esc_html($next_post->post_title); ?></span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Author Bio -->
                    <div class="author-bio">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                        </div>
                        <div class="author-info">
                            <h4 class="author-name"><?php echo get_the_author(); ?></h4>
                            <?php if (get_the_author_meta('description')) : ?>
                                <p class="author-description"><?php echo get_the_author_meta('description'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                
                <!-- Comments -->
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </main>
            
            <aside class="blog-sidebar">
                <?php if (is_active_sidebar('blog-sidebar')) : ?>
                    <?php dynamic_sidebar('blog-sidebar'); ?>
                <?php else : ?>
                    <!-- Default sidebar content -->
                    <div class="widget">
                        <h3 class="widget-title"><?php esc_html_e('Related Posts', 'uae-villas'); ?></h3>
                        <?php
                        $related_posts = new WP_Query(array(
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'category__in' => wp_get_post_categories(get_the_ID()),
                            'orderby' => 'rand',
                        ));
                        
                        if ($related_posts->have_posts()) :
                        ?>
                            <ul class="related-posts-list">
                                <?php
                                while ($related_posts->have_posts()) : $related_posts->the_post();
                                ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="related-post-thumb">
                                                    <?php the_post_thumbnail('thumbnail'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="related-post-content">
                                                <h5><?php the_title(); ?></h5>
                                                <span class="related-post-date"><?php echo get_the_date(); ?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php
                        wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    
                    <div class="widget">
                        <h3 class="widget-title"><?php esc_html_e('Categories', 'uae-villas'); ?></h3>
                        <ul>
                            <?php wp_list_categories(array('title_li' => '')); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>


