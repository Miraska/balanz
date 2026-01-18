<?php
/**
 * What This Offers Section
 * 
 * @package Balanz
 */

$title = get_field('offers_title') ?: 'What This Offers';
$subtitle = get_field('offers_subtitle') ?: 'a thoughtful balance of nourishment, convenience, and emotional ease — designed to support your body and mind every day.';
$rational_title = get_field('rational_title') ?: 'Rational Benefits';
$rational_benefits = get_field('rational_benefits'); // Repeater
$emotional_title = get_field('emotional_title') ?: 'Emotional Benefit';
$emotional_benefits = get_field('emotional_benefits'); // Repeater

// Food images
$food_image_1 = get_field('offers_image_1');
$food_image_2 = get_field('offers_image_2');
$food_1_url = $food_image_1 ? $food_image_1['url'] : get_template_directory_uri() . '/assets/images/what-this-offers/food-01.jpg';
$food_2_url = $food_image_2 ? $food_image_2['url'] : get_template_directory_uri() . '/assets/images/what-this-offers/food-02.jpg';
?>

<section class="offers-section" id="offers">
    <div class="offers-container">
        
        <!-- Section Header -->
        <header class="offers-header animate-on-scroll">
            <h2 class="offers-title"><?php echo esc_html($title); ?></h2>
            <?php if ($subtitle): ?>
            <p class="offers-subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
        </header>
        
        <!-- Benefits Grid -->
        <div class="offers-grid">
            
            <!-- Rational Benefits Card -->
            <div class="offers-card offers-card-text animate-on-scroll">
                <h3 class="offers-card-title"><?php echo esc_html($rational_title); ?></h3>
                <ul class="offers-list">
                    <?php 
                    if ($rational_benefits):
                        foreach ($rational_benefits as $benefit):
                    ?>
                    <li class="offers-item">
                        <svg class="item-icon" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                        <span class="item-text"><?php echo esc_html($benefit['text']); ?></span>
                    </li>
                    <?php 
                        endforeach;
                    else:
                        $defaults = [
                            'Natural products without additives',
                            'Delivery and portions for the entire day',
                            'Provides freedom without fanatical calorie counting',
                        ];
                        foreach ($defaults as $text):
                    ?>
                    <li class="offers-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/check-mark.svg" alt="Delicious balanced meal" width="26px" height="26px">
                        <span class="item-text"><?php echo $text; ?></span>
                    </li>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>

            <!-- Food Image 1 -->
            <div class="offers-card offers-card-image animate-on-scroll">
                <img src="<?php echo esc_url($food_1_url); ?>" alt="Delicious balanced meal" class="offers-image">
            </div>

            <!-- Food Image 2 -->
            <div class="offers-card offers-card-image animate-on-scroll">
                <img src="<?php echo esc_url($food_2_url); ?>" alt="Healthy meal preparation" class="offers-image">
            </div>
            
            <!-- Emotional Benefits Card -->
            <div class="offers-card offers-card-text animate-on-scroll">
                <h3 class="offers-card-title"><?php echo esc_html($emotional_title); ?></h3>
                <ul class="offers-list">
                    <?php 
                    if ($emotional_benefits):
                        foreach ($emotional_benefits as $benefit):
                    ?>
                    <li class="offers-item">
                        <svg class="item-icon" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M8 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        </svg>
                        <span class="item-text"><?php echo esc_html($benefit['text']); ?></span>
                    </li>
                    <?php 
                        endforeach;
                    else:
                        $defaults = [
                            'Peace of mind — we\'ve taken care of you',
                            'Lightness without guilt',
                            'A beautiful ritual in a state of resourcefulness',
                            'Sense of harmony and control',
                        ];
                        foreach ($defaults as $text):
                    ?>
                    <li class="offers-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/check-mark.svg" alt="Delicious balanced meal" width="26px" height="26px">
                        <span class="item-text"><?php echo $text; ?></span>
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
