<?php
/**
 * 404 Error Page Template
 * 
 * @package Balanz
 */

get_header();
?>

<section class="error-404 not-found" style="min-height: 60vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 60px 20px;">
    <div class="error-content" style="max-width: 600px;">
        
        <!-- Error Number -->
        <div class="error-number" style="font-size: clamp(100px, 20vw, 200px); font-weight: 700; line-height: 1; color: #f0f0f0; margin-bottom: 20px;">
            404
        </div>
        
        <!-- Error Title -->
        <h1 class="error-title" style="font-size: clamp(24px, 5vw, 36px); font-weight: 600; margin-bottom: 16px; color: #1a1a1a;">
            <?php esc_html_e('Page Not Found', 'balanz'); ?>
        </h1>
        
        <!-- Error Message -->
        <p class="error-message" style="font-size: 16px; color: #666; margin-bottom: 32px; line-height: 1.6;">
            <?php esc_html_e("Sorry, the page you're looking for doesn't exist or has been moved.", 'balanz'); ?>
        </p>
        
        <!-- Back Home Button -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-download-app" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; background: #1a1a1a; color: #fff; text-decoration: none; border-radius: 50px; font-weight: 500; transition: all 0.3s ease;">
            <span><?php esc_html_e('Back to Home', 'balanz'); ?></span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
        
    </div>
</section>

<style>
    .error-404 .btn-download-app:hover {
        background: #333;
        transform: translateY(-2px);
    }
    
    .error-404 .error-number {
        background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
</style>

<?php
get_footer();
