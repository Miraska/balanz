<?php
/**
 * CTA Section - Start Your Journey
 * 
 * @package Balanz
 */

$title = get_field('cta_title') ?: 'Start your journey to balance today';
$subtitle = get_field('cta_subtitle') ?: 'Try the first week with a 20% discount';
$btn_primary_text = get_field('cta_btn_primary') ?: 'Choose Program';
$btn_secondary_text = get_field('cta_btn_secondary') ?: 'Ask a Question';
?>

<section class="cta-section" id="cta">
    <!-- Background Image -->
    <div class="cta-background">
        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta/bg.jpg" alt="Background">
    </div>
    
    <!-- Phone Images -->
    <div class="cta-phones">
        <div class="cta-phone cta-phone-left" data-phone="left">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta/phone-01.png" alt="Phone 1">
        </div>
        <div class="cta-phone cta-phone-right" data-phone="right">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta/phone-02.png" alt="Phone 2">
        </div>
        <div class="cta-phone cta-phone-center" data-phone="center">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta/phone-03.png" alt="Phone 3">
        </div>
        <div class="cta-phone cta-phone-center-right" data-phone="center-right">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/cta/phone-01.png" alt="Phone 4">
        </div>
    </div>
    
    <!-- Content -->
    <div class="cta-container">
        <div class="cta-content">
            <h2 class="cta-title"><?php echo esc_html($title); ?></h2>
            <p class="cta-subtitle"><?php echo esc_html($subtitle); ?></p>
            
            <div class="cta-buttons">
                <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn btn-primary cta-btn-primary">
                    <?php echo esc_html($btn_primary_text); ?>
                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/link.svg" alt="Link">
                </a>
                <a href="#contact" class="btn btn-outline cta-btn-secondary">
                    <?php echo esc_html($btn_secondary_text); ?>
                </a>
            </div>
        </div>
    </div>
</section>
