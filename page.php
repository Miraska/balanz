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
    <section class="page-hero" style="padding: 80px 20px 60px; text-align: center; background: linear-gradient(135deg, #fafafa 0%, #f0f0f0 100%);">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            <h1 class="page-title" style="font-size: clamp(32px, 6vw, 48px); font-weight: 700; color: #1a1a1a; margin-bottom: 16px;">
                <?php the_title(); ?>
            </h1>
            
            <?php 
            // Show excerpt if available
            $excerpt = get_the_excerpt();
            if ($excerpt) : 
            ?>
            <p class="page-excerpt" style="font-size: 18px; color: #666; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                <?php echo esc_html($excerpt); ?>
            </p>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Page Content -->
    <section class="page-main-content" style="padding: 60px 20px;">
        <div class="container" style="max-width: 800px; margin: 0 auto;">
            
            <div class="entry-content" style="font-size: 16px; line-height: 1.8; color: #333;">
                <?php 
                the_content();
                
                // Pagination for multi-page posts
                wp_link_pages([
                    'before' => '<div class="page-links" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;"><span style="font-weight: 600;">Pages:</span> ',
                    'after'  => '</div>',
                ]);
                ?>
            </div>
            
            <?php 
            // Show edit link for logged in users
            edit_post_link(
                __('Edit this page', 'balanz'),
                '<p class="edit-link" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">',
                '</p>'
            );
            ?>
            
        </div>
    </section>
    
    <?php endwhile; endif; ?>
    
</article>

<style>
    /* Typography styles for page content */
    .entry-content h2 {
        font-size: 28px;
        font-weight: 600;
        margin: 40px 0 16px;
        color: #1a1a1a;
    }
    
    .entry-content h3 {
        font-size: 22px;
        font-weight: 600;
        margin: 32px 0 12px;
        color: #1a1a1a;
    }
    
    .entry-content h4 {
        font-size: 18px;
        font-weight: 600;
        margin: 24px 0 12px;
        color: #1a1a1a;
    }
    
    .entry-content p {
        margin-bottom: 20px;
    }
    
    .entry-content ul,
    .entry-content ol {
        margin: 20px 0;
        padding-left: 24px;
    }
    
    .entry-content li {
        margin-bottom: 8px;
    }
    
    .entry-content a {
        color: #0066cc;
        text-decoration: underline;
    }
    
    .entry-content a:hover {
        color: #004499;
    }
    
    .entry-content blockquote {
        margin: 30px 0;
        padding: 20px 24px;
        background: #f9f9f9;
        border-left: 4px solid #1a1a1a;
        font-style: italic;
        color: #555;
    }
    
    .entry-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    
    .entry-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    
    .entry-content th,
    .entry-content td {
        padding: 12px;
        border: 1px solid #e0e0e0;
        text-align: left;
    }
    
    .entry-content th {
        background: #f5f5f5;
        font-weight: 600;
    }
    
    .edit-link a {
        color: #666;
        font-size: 14px;
        text-decoration: none;
    }
    
    .edit-link a:hover {
        color: #1a1a1a;
    }
</style>

<?php
get_footer();
