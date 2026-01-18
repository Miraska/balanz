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

// Food card images
$food_card_1 = get_field('why_food_card_1');
$food_card_2 = get_field('why_food_card_2');
$food_card_1_url = $food_card_1 ? $food_card_1['url'] : BALANZ_THEME_URI . '/assets/images/why-this-matters/food-card-01.png';
$food_card_2_url = $food_card_2 ? $food_card_2['url'] : BALANZ_THEME_URI . '/assets/images/why-this-matters/food-card-02.png';
?>

<section class="why-section" id="why-matters">
    <div class="why-container">
        <div class="why-content">
            
            <!-- Image Side -->
            <div class="why-images">
                <div class="why-image-main">
                    <?php if ($image): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    <?php else: ?>
                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/why-this-matters/why-this-matters.png" alt="Why Balanz">
                    <?php endif; ?>
                </div>
                
                <!-- Food Cards -->
                <div class="food-cards-wrapper">
                    <div class="food-card food-card-1">
                        <img src="<?php echo esc_url($food_card_1_url); ?>" alt="Food Card 1">
                    </div>
                    
                    <div class="food-card food-card-2">
                        <img src="<?php echo esc_url($food_card_2_url); ?>" alt="Food Card 2">
                    </div>
                </div>
            </div>
            
            <!-- Text Side -->
            <div class="why-text">
                <div class="why-header">
                    <h2 class="why-title"><?php echo esc_html($title); ?></h2>
                    <?php if ($subtitle): ?>
                    <p class="why-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php else: ?>
                    <p class="why-subtitle">A simpler way to eat well, without stress or constant decisions.</p>
                    <?php endif; ?>
                </div>
                
                <ul class="why-benefits">
                    <?php 
                    if ($benefits):
                        foreach ($benefits as $benefit):
                    ?>
                    <li class="why-benefit">
                        <div class="benefit-icon">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/check-mark.svg" alt="">
                        </div>
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
                        <div class="benefit-icon">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/check-mark.svg" alt="">
                        </div>
                        <span class="benefit-text"><?php echo esc_html($benefit); ?></span>
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
