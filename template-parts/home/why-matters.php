<?php
/**
 * Why This Matters Section
 * 
 * @package Balanz
 */

$title = get_field('why_title') ?: 'Why This Matters';
$subtitle = get_field('why_subtitle');
$image = get_field('why_image');
$badge_label = get_field('why_badge_label');
$badge_value = get_field('why_badge_value');
$benefits = get_field('why_benefits'); // Repeater
?>

<section class="why-section" id="why-matters">
    <div class="why-container">
        <div class="why-content">
            
            <!-- Image Side -->
            <div class="why-images animate-on-scroll">
                <div class="why-image-main">
                    <?php if ($image): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    <?php else: ?>
                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/why-this-matters.png" alt="Why Balanz">
                    <?php endif; ?>
                </div>
                
                <?php if ($badge_label || $badge_value): ?>
                <div class="why-image-badge">
                    <span class="badge-label"><?php echo esc_html($badge_label ?: 'based on'); ?></span>
                    <div class="badge-value">
                        <span class="stars">★★★★★</span>
                        <span class="rating"><?php echo esc_html($badge_value ?: '500+ reviews'); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Text Side -->
            <div class="why-text animate-on-scroll">
                <h2 class="why-title"><?php echo esc_html($title); ?></h2>
                <?php if ($subtitle): ?>
                <p class="why-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                
                <ul class="why-benefits">
                    <?php 
                    if ($benefits):
                        foreach ($benefits as $benefit):
                    ?>
                    <li class="why-benefit">
                        <svg class="benefit-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                            <polyline points="22,4 12,14.01 9,11.01"/>
                        </svg>
                        <span class="benefit-text"><?php echo esc_html($benefit['text']); ?></span>
                    </li>
                    <?php 
                        endforeach;
                    else:
                        // Default benefits
                        $default_benefits = [
                            'Eliminates daily choice stress',
                            'Frees up time for family, work, and relaxation',
                            'Provides freedom without fanatical calorie counting',
                            'Supports energy and clarity',
                        ];
                        foreach ($default_benefits as $benefit):
                    ?>
                    <li class="why-benefit">
                        <svg class="benefit-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                            <polyline points="22,4 12,14.01 9,11.01"/>
                        </svg>
                        <span class="benefit-text"><?php echo $benefit; ?></span>
                    </li>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            
        </div>
    </div>
</section>
