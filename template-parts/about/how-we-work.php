<?php
/**
 * How We Work Section
 * 
 * @package Balanz
 */

$title = get_field('hww_title') ?: 'How We Work';
$steps = get_field('hww_steps'); // Repeater
?>

<section class="how-we-work-section">
    <div class="how-we-work-container">
        <h2 class="how-we-work-title animate-on-scroll"><?php echo esc_html($title); ?></h2>
        
        <div class="work-steps animate-stagger">
            <?php 
            if ($steps):
                foreach ($steps as $index => $step):
            ?>
            <div class="work-step animate-child">
                <span class="step-number"><?php echo $index + 1; ?></span>
                <?php if ($step['icon']): ?>
                <img src="<?php echo esc_url($step['icon']['url']); ?>" alt="" class="step-icon">
                <?php endif; ?>
                <span class="step-text"><?php echo esc_html($step['text']); ?></span>
            </div>
            <?php 
                endforeach;
            else:
                $defaults = [
                    'Product selection',
                    'Preparation',
                    'Packaging',
                    'Quality control',
                ];
                foreach ($defaults as $index => $text):
            ?>
            <div class="work-step animate-child">
                <span class="step-number"><?php echo $index + 1; ?></span>
                <span class="step-text"><?php echo $text; ?></span>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
