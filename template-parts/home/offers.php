<?php
/**
 * What This Offers Section
 * 
 * @package Balanz
 */

$title = get_field('offers_title') ?: 'What This Offers';
$subtitle = get_field('offers_subtitle');
$rational_title = get_field('rational_title') ?: 'Rational Benefits';
$rational_benefits = get_field('rational_benefits'); // Repeater
$emotional_title = get_field('emotional_title') ?: 'Emotional Benefit';
$emotional_benefits = get_field('emotional_benefits'); // Repeater
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
            
            <!-- Rational Benefits -->
            <div class="offers-card animate-on-scroll">
                <h3 class="offers-card-title"><?php echo esc_html($rational_title); ?></h3>
                <ul class="offers-list">
                    <?php 
                    if ($rational_benefits):
                        foreach ($rational_benefits as $benefit):
                    ?>
                    <li class="offers-item">
                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9 12l2 2 4-4"/>
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
                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                        <span class="item-text"><?php echo $text; ?></span>
                    </li>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </ul>
            </div>
            
            <!-- Emotional Benefits -->
            <div class="offers-card card-emotional animate-on-scroll">
                <h3 class="offers-card-title"><?php echo esc_html($emotional_title); ?></h3>
                <ul class="offers-list">
                    <?php 
                    if ($emotional_benefits):
                        foreach ($emotional_benefits as $benefit):
                    ?>
                    <li class="offers-item">
                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9 12l2 2 4-4"/>
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
                        <svg class="item-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
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
