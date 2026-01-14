<?php
/**
 * CTA Section - Start Your Journey
 * 
 * @package Balanz
 */

$title = get_field('cta_title') ?: 'Start your journey to balance today';
$subtitle = get_field('cta_subtitle') ?: 'Try the first week with a 30% discount';
$btn_primary_text = get_field('cta_btn_primary') ?: 'Choose Program';
$btn_secondary_text = get_field('cta_btn_secondary') ?: 'Ask a Question';
?>

<section class="cta-section" id="cta">
    <div class="cta-container">
        
        <div class="cta-content animate-on-scroll">
            <h2 class="cta-title"><?php echo esc_html($title); ?></h2>
            <p class="cta-subtitle"><?php echo esc_html($subtitle); ?></p>
            
            <div class="cta-buttons">
                <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn btn-primary">
                    <?php echo esc_html($btn_primary_text); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="#contact" class="btn btn-outline">
                    <?php echo esc_html($btn_secondary_text); ?>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3M12 17h.01"/>
                    </svg>
                </a>
            </div>
        </div>
        
    </div>
    
    <!-- Decorations -->
    <div class="cta-decorations">
        <div class="cta-food-image food-left">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta-food-left.png" alt="">
        </div>
        <div class="cta-food-image food-right">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta-food-right.png" alt="">
        </div>
        <div class="cta-phone-mockup">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/phone-mockup.png" alt="">
        </div>
    </div>
</section>
