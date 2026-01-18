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
$btn_primary_link = get_field('cta_btn_primary_link') ?: get_field('download_link', 'option') ?: '#';
$btn_secondary_link = get_field('cta_btn_secondary_link') ?: '#contact';

// Images
$background = get_field('cta_background');
$phone_1 = get_field('cta_phone_1');
$phone_2 = get_field('cta_phone_2');
$phone_3 = get_field('cta_phone_3');

$bg_url = $background ? $background['url'] : BALANZ_THEME_URI . '/assets/images/cta/bg.jpg';
$phone_1_url = $phone_1 ? $phone_1['url'] : BALANZ_THEME_URI . '/assets/images/cta/phone-01.png';
$phone_2_url = $phone_2 ? $phone_2['url'] : BALANZ_THEME_URI . '/assets/images/cta/phone-02.png';
$phone_3_url = $phone_3 ? $phone_3['url'] : BALANZ_THEME_URI . '/assets/images/cta/phone-03.png';
?>

<section class="cta-section" id="cta">
    <!-- Background Image -->
    <div class="cta-background">
        <img src="<?php echo esc_url($bg_url); ?>" alt="Background">
    </div>
    
    <!-- Phone Images -->
    <div class="cta-phones">
        <div class="cta-phone cta-phone-left" data-phone="left">
            <img src="<?php echo esc_url($phone_1_url); ?>" alt="Phone 1">
        </div>
        <div class="cta-phone cta-phone-right" data-phone="right">
            <img src="<?php echo esc_url($phone_2_url); ?>" alt="Phone 2">
        </div>
        <div class="cta-phone cta-phone-center" data-phone="center">
            <img src="<?php echo esc_url($phone_3_url); ?>" alt="Phone 3">
        </div>
        <div class="cta-phone cta-phone-center-right" data-phone="center-right">
            <img src="<?php echo esc_url($phone_1_url); ?>" alt="Phone 4">
        </div>
    </div>
    
    <!-- Content -->
    <div class="cta-container">
        <div class="cta-content">
            <h2 class="cta-title"><?php echo esc_html($title); ?></h2>
            <p class="cta-subtitle"><?php echo esc_html($subtitle); ?></p>
            
            <div class="cta-buttons">
                <a href="<?php echo esc_url($btn_primary_link); ?>" class="btn btn-primary cta-btn-primary">
                    <?php echo esc_html($btn_primary_text); ?>
                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/link.svg" alt="Link">
                </a>
                <a href="<?php echo esc_url($btn_secondary_link); ?>" class="btn btn-outline cta-btn-secondary">
                    <?php echo esc_html($btn_secondary_text); ?>
                </a>
            </div>
        </div>
    </div>
</section>
