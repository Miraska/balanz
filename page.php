<?php
/**
 * Default Page Template
 * 
 * Used for pages that don't have a specific template assigned.
 * 
 * @package Balanz
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
    
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <h1 class="page-title">
                <?php the_title(); ?>
            </h1>
            
            <?php 
            // Show excerpt if available
            $excerpt = get_the_excerpt();
            if ($excerpt) : 
            ?>
            <p class="page-excerpt">
                <?php echo esc_html($excerpt); ?>
            </p>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Page Content -->
    <section class="page-main-content">
        <div class="container">
            
            <div class="entry-content">
                <?php 
                the_content();
                
                // Pagination for multi-page posts
                wp_link_pages([
                    'before' => '<div class="page-links"><span>Pages:</span> ',
                    'after'  => '</div>',
                ]);
                ?>
            </div>
            
            <?php 
            // Show edit link for logged in users
            edit_post_link(
                __('Edit this page', 'balanz'),
                '<p class="edit-link">',
                '</p>'
            );
            ?>
            
        </div>
    </section>
    
    <?php endwhile; endif; ?>
    
</article>

<?php
get_footer();
