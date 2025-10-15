<?php
/**
 * Template part for displaying blog post cards
 *
 * @package UAE_Villas
 * @since 1.0.0
 */
?>

<article class="blog-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="blog-card-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <div class="blog-card-content">
        <div class="blog-card-meta">
            <span class="blog-card-date">
                <i class="fas fa-calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
            
            <span class="blog-card-category">
                <i class="fas fa-folder"></i>
                <?php
                $categories = get_the_category();
                if (!empty($categories)) {
                    echo esc_html($categories[0]->name);
                }
                ?>
            </span>
        </div>
        
        <h2 class="blog-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
        
        <div class="blog-card-excerpt">
            <?php the_excerpt(); ?>
        </div>
        
        <div class="blog-card-footer">
            <a href="<?php the_permalink(); ?>" class="read-more-link">
                <?php esc_html_e('Read More', 'uae-villas'); ?>
                <i class="fas fa-arrow-right"></i>
            </a>
            
            <div class="blog-card-author">
                <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                <span><?php echo get_the_author(); ?></span>
            </div>
        </div>
    </div>
</article>


