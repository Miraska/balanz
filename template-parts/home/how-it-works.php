<?php
/**
 * How It Works Section
 * 
 * @package Balanz
 */

$title = get_field('hiw_title') ?: 'How it Works';
$description = get_field('hiw_description') ?: 'From choosing your goal to enjoying fresh meals — Balanz takes care of the details so you don\'t have to.';
$steps = get_field('hiw_steps'); // Repeater
?>

<section class="hiw-section" id="how-it-works">
    <div class="hiw-container">
        
        <!-- Section Header -->
        <header class="hiw-header animate-on-scroll">
            <h2 class="hiw-title"><?php echo esc_html($title); ?></h2>
            <p class="hiw-description"><?php echo esc_html($description); ?></p>
        </header>
        
        <!-- Content -->
        <div class="hiw-content">
            
            <!-- Step Image (Left side) -->
            <div class="hiw-image-container">
                <div class="hiw-image-wrapper animate-on-scroll">
                    <div class="hiw-image" id="hiwImage">
                        <?php 
                        if ($steps):
                            foreach ($steps as $index => $step): 
                                if ($step['image']):
                        ?>
                        <img src="<?php echo esc_url($step['image']['url']); ?>" 
                             alt="<?php echo esc_attr($step['title']); ?>"
                             class="<?php echo $index === 0 ? 'is-active' : 'is-hidden'; ?>"
                             data-step-image="<?php echo $index; ?>">
                        <?php 
                                endif;
                            endforeach;
                        else:
                        ?>
                        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/steps/step-1.png" alt="Step 1" class="is-active" data-step-image="0">
                        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/steps/step-2.png" alt="Step 2" class="is-hidden" data-step-image="1">
                        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/steps/step-3.png" alt="Step 3" class="is-hidden" data-step-image="2">
                        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/steps/step-4.png" alt="Step 4" class="is-hidden" data-step-image="3">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Steps List (Right side) -->
            <div class="hiw-steps" id="hiwSteps">
                <?php 
                if ($steps):
                    foreach ($steps as $index => $step): 
                        $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                ?>
                <div class="hiw-step <?php echo $index === 0 ? 'is-active' : ''; ?>" data-step="<?php echo $index; ?>">
                    <span class="hiw-step-number"><?php echo $number; ?>.</span>
                    <div class="hiw-step-content">
                        <h3 class="hiw-step-title"><?php echo esc_html($step['title']); ?></h3>
                        <p class="hiw-step-description"><?php echo esc_html($step['description']); ?></p>
                    </div>
                </div>
                <?php 
                    endforeach;
                else:
                    // Default steps
                    $default_steps = [
                        ['title' => 'Choose your goal and limit', 'desc' => 'Tell us what you\'re aiming for — balance, shape, energy, or simply eating freely. Choose a calorie limit (or no limit), and we\'ll adapt everything around it.'],
                        ['title' => 'Select your meal set', 'desc' => 'Choose how you want to plan your meals. Build your own day by selecting dishes, or let BALANZ suggest ready-made meal sets that match your daily calorie target. Every option is designed for balance and consistency.'],
                        ['title' => 'The app calculates', 'desc' => 'BALANZ automatically calculates total daily calories and clearly shows your Goal / Selected / Remaining intake. Meals are planned at least 2 days in advance, so portions stay accurate and your routine stays predictable.'],
                        ['title' => 'Deliver fresh food', 'desc' => 'Your meals are freshly prepared, pre-portioned, and delivered every morning within your chosen time window. Simply follow your plan — BALANZ takes care of the preparation and delivery.'],
                    ];
                    foreach ($default_steps as $index => $step):
                        $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                ?>
                <div class="hiw-step <?php echo $index === 0 ? 'is-active' : ''; ?>" data-step="<?php echo $index; ?>">
                    <span class="hiw-step-number"><?php echo $number; ?>.</span>
                    <div class="hiw-step-content">
                        <h3 class="hiw-step-title"><?php echo $step['title']; ?></h3>
                        <p class="hiw-step-description"><?php echo $step['desc']; ?></p>
                    </div>
                </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
            
        </div>
    </div>
</section>
