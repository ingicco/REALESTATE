<?php
/**
 * The template for displaying property archive
 *
 * @package UAE_Villas
 * @since 1.0.0
 */

get_header(); ?>

<!-- Page Header -->
<section class="properties-header">
    <div class="container">
        <h1 class="page-title"><?php echo esc_html(get_theme_mod('properties_page_title', 'Discover Your Ideal Villa in the UAE')); ?></h1>
        <p class="page-subtitle"><?php echo esc_html(get_theme_mod('properties_page_subtitle', 'Use the filters below to search our complete portfolio of luxury properties across Dubai\'s most exclusive communities.')); ?></p>
    </div>
</section>

<!-- Search & Filter Bar -->
<section class="search-filters">
    <div class="container">
        <form class="filter-form" id="propertyFilters" method="GET">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="searchKeyword"><?php esc_html_e('Community or Keyword', 'uae-villas'); ?></label>
                    <input type="text" id="searchKeyword" name="search_keyword" placeholder="<?php esc_attr_e('e.g., Palm Jumeirah, golf view', 'uae-villas'); ?>" value="<?php echo esc_attr(get_query_var('search_keyword')); ?>">
                </div>
                
                <div class="filter-group">
                    <label for="community"><?php esc_html_e('Community', 'uae-villas'); ?></label>
                    <select id="community" name="property_community">
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
                </div>
                
                <div class="filter-group">
                    <label for="bedrooms"><?php esc_html_e('Minimum Bedrooms', 'uae-villas'); ?></label>
                    <select id="bedrooms" name="min_bedrooms">
                        <option value=""><?php esc_html_e('Any', 'uae-villas'); ?></option>
                        <?php
                        for ($i = 2; $i <= 6; $i++) :
                            $selected = (get_query_var('min_bedrooms') == $i) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $i; ?>" <?php echo $selected; ?>>
                                <?php printf(esc_html__('%d+ Bedrooms', 'uae-villas'), $i); ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="priceRange"><?php esc_html_e('Price Range', 'uae-villas'); ?></label>
                    <select id="priceRange" name="price_range">
                        <option value=""><?php esc_html_e('Any Price', 'uae-villas'); ?></option>
                        <?php
                        $price_ranges = array(
                            '0-10000000' => __('Under AED 10M', 'uae-villas'),
                            '10000000-25000000' => __('AED 10M - 25M', 'uae-villas'),
                            '25000000-50000000' => __('AED 25M - 50M', 'uae-villas'),
                            '50000000-100000000' => __('AED 50M - 100M', 'uae-villas'),
                            '100000000-999999999' => __('Above AED 100M', 'uae-villas'),
                        );
                        
                        foreach ($price_ranges as $value => $label) :
                            $selected = (get_query_var('price_range') === $value) ? 'selected' : '';
                            ?>
                            <option value="<?php echo esc_attr($value); ?>" <?php echo $selected; ?>>
                                <?php echo esc_html($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary search-btn">
                        <i class="fas fa-search"></i>
                        <?php esc_html_e('Search', 'uae-villas'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Results Summary -->
<section class="results-summary">
    <div class="container">
        <div class="summary-content">
            <p class="results-count" id="resultsCount">
                <?php
                global $wp_query;
                $total = $wp_query->found_posts;
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $per_page = get_query_var('posts_per_page');
                $start = ($paged - 1) * $per_page + 1;
                $end = min($paged * $per_page, $total);
                
                if ($total > 0) {
                    printf(
                        esc_html__('Showing %d-%d of %d properties', 'uae-villas'),
                        $start,
                        $end,
                        $total
                    );
                } else {
                    esc_html_e('No properties found', 'uae-villas');
                }
                ?>
            </p>
            <div class="sort-options">
                <label for="sortBy"><?php esc_html_e('Sort by:', 'uae-villas'); ?></label>
                <select id="sortBy" name="orderby">
                    <option value="featured" <?php selected(get_query_var('orderby'), 'featured'); ?>><?php esc_html_e('Featured', 'uae-villas'); ?></option>
                    <option value="price_low" <?php selected(get_query_var('orderby'), 'price_low'); ?>><?php esc_html_e('Price: Low to High', 'uae-villas'); ?></option>
                    <option value="price_high" <?php selected(get_query_var('orderby'), 'price_high'); ?>><?php esc_html_e('Price: High to Low', 'uae-villas'); ?></option>
                    <option value="bedrooms" <?php selected(get_query_var('orderby'), 'bedrooms'); ?>><?php esc_html_e('Bedrooms', 'uae-villas'); ?></option>
                    <option value="date" <?php selected(get_query_var('orderby'), 'date'); ?>><?php esc_html_e('Newest First', 'uae-villas'); ?></option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Property Listings Grid -->
<section class="property-listings">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="properties-grid" id="propertiesGrid">
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/property-card');
                endwhile;
                ?>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-section">
                <nav class="pagination" id="pagination">
                    <?php
                    $pagination_args = array(
                        'mid_size'  => 2,
                        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __('Previous', 'uae-villas'),
                        'next_text' => __('Next', 'uae-villas') . ' <i class="fas fa-chevron-right"></i>',
                        'class'     => 'pagination-btn',
                    );
                    
                    echo paginate_links($pagination_args);
                    ?>
                </nav>
                
                <div class="pagination-info">
                    <p id="paginationInfo">
                        <?php
                        $paged = max(1, get_query_var('paged'));
                        $max_pages = $wp_query->max_num_pages;
                        if ($max_pages > 1) {
                            printf(
                                esc_html__('Page %d of %d', 'uae-villas'),
                                $paged,
                                $max_pages
                            );
                        }
                        ?>
                    </p>
                </div>
            </div>
            
        <?php else : ?>
            <!-- No Results State -->
            <div class="no-results" id="noResults">
                <i class="fas fa-search"></i>
                <h3><?php esc_html_e('No properties found', 'uae-villas'); ?></h3>
                <p><?php esc_html_e('Try adjusting your search criteria or browse all properties.', 'uae-villas'); ?></p>
                <a href="<?php echo esc_url(get_post_type_archive_link('property')); ?>" class="btn btn-outline">
                    <?php esc_html_e('Clear All Filters', 'uae-villas'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>


