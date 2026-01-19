<?php
/**
 * 404 Error Page Template
 * 
 * @package Balanz
 */

get_header();
?>

<section class="error-404 not-found">
    <div class="error-content">
        
        <!-- Error Number -->
        <div class="error-number">
            404
        </div>
        
        <!-- Error Title -->
        <h1 class="error-title">
            <?php esc_html_e('Page Not Found', 'balanz'); ?>
        </h1>
        
        <!-- Error Message -->
        <p class="error-message">
            <?php esc_html_e("Sorry, the page you're looking for doesn't exist or has been moved.", 'balanz'); ?>
        </p>
        
        <!-- Back Home Button -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="error-btn">
            <span><?php esc_html_e('Back to Home', 'balanz'); ?></span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
        
    </div>
</section>

<?php
get_footer();
