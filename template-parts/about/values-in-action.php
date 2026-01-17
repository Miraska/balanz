<?php
/**
 * Values in Action Section
 * 
 * Auto-play animation with 6000ms interval
 * Click to select step (resets timer)
 * 
 * @package Balanz
 */

$title = get_field('via_title') ?: 'Values in Action';
$description = get_field('via_description') ?: 'Each Balanz value is reflected in how we select ingredients, design menus, and deliver meals every day.';
$steps = get_field('via_steps'); // Repeater

// Default steps if ACF not set
$default_steps = [
    [
        'title' => 'Naturalness',
        'description' => 'We create menus from whole foods, no artificial additives'
    ],
    [
        'title' => 'Simplicity and Honesty',
        'description' => 'We write clear ingredient lists, weigh portions accurately'
    ],
    [
        'title' => 'Consistency',
        'description' => 'We deliver every day to help you build a habit'
    ],
    [
        'title' => 'Aesthetics of Care',
        'description' => 'Each package is a gift to yourself'
    ],
    [
        'title' => 'Energy of Life',
        'description' => 'We select products for stable energy'
    ],
    [
        'title' => 'Mindfulness',
        'description' => 'We teach you to understand your body\'s signals through our materials'
    ]
];

// Use ACF steps if available, otherwise use defaults
$steps_data = $steps ?: $default_steps;
?>

<section class="via-section" id="values-in-action">
    <div class="via-container">
        
        <!-- Section Header -->
        <header class="via-header animate-on-scroll">
            <h2 class="via-title"><?php echo esc_html($title); ?></h2>
            <p class="via-description"><?php echo esc_html($description); ?></p>
        </header>
        
        <!-- Content -->
        <div class="via-content">
            
            <!-- Steps List (Left side on desktop) -->
            <div class="via-steps" id="viaSteps">
                <?php foreach ($steps_data as $index => $step): 
                    $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $title_text = isset($step['title']) ? $step['title'] : '';
                    $desc_text = isset($step['description']) ? $step['description'] : (isset($step['desc']) ? $step['desc'] : '');
                    $image_url = isset($step['image']['url']) ? $step['image']['url'] : BALANZ_THEME_URI . '/assets/images/about/values-in-action/content-' . $number . '.jpg';
                ?>
                <div class="via-step <?php echo $index === 0 ? 'is-active' : ''; ?>" data-step="<?php echo $index; ?>">
                    <span class="via-step-number"><?php echo $number; ?>.</span>
                    
                    <div class="via-step-content">
                        <h3 class="via-step-title"><?php echo esc_html($title_text); ?></h3>
                        <p class="via-step-description"><?php echo esc_html($desc_text); ?></p>
                    </div>
                    
                    <!-- Image inside card (for mobile/tablet) -->
                    <div class="via-step-image-mobile">
                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="<?php echo esc_attr($title_text); ?>">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Step Image (Right side on desktop) -->
            <div class="via-image-container">
                <div class="via-image-wrapper animate-on-scroll">
                    <div class="via-image" id="viaImage">
                        <?php foreach ($steps_data as $index => $step): 
                            $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                            $title_text = isset($step['title']) ? $step['title'] : '';
                            $image_url = isset($step['image']['url']) ? $step['image']['url'] : BALANZ_THEME_URI . '/assets/images/about/values-in-action/content-' . $number . '.jpg';
                        ?>
                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="<?php echo esc_attr($title_text); ?>"
                             class="<?php echo $index === 0 ? 'is-active' : 'is-hidden'; ?>"
                             data-step-image="<?php echo $index; ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
