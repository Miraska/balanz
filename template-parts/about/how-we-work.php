<?php
/**
 * How We Work Section - About Page
 * 
 * @package Balanz
 */

$title = get_field('hww_title') ?: 'How We Work';
$subtitle = get_field('hww_subtitle') ?: 'From choosing your goal to enjoying fresh meals - Balanz takes care of the details so you don\'t have to.';

// Default steps data
$default_steps = [
    [
        'icon' => get_template_directory_uri() . '/assets/images/about/how-we-work/icons/01.svg',
        'text' => 'Product selection'
    ],
    [
        'icon' => get_template_directory_uri() . '/assets/images/about/how-we-work/icons/02.svg',
        'text' => 'Preparation'
    ],
    [
        'icon' => get_template_directory_uri() . '/assets/images/about/how-we-work/icons/03.svg',
        'text' => 'Packaging'
    ],
    [
        'icon' => get_template_directory_uri() . '/assets/images/about/how-we-work/icons/04.svg',
        'text' => 'Quality control'
    ],
];

$steps = get_field('hww_steps') ?: $default_steps;
$background = get_field('hww_background');
$bg_image = $background ? $background['url'] : get_template_directory_uri() . '/assets/images/about/how-we-work/bg.jpg';
$arrow_icon = get_template_directory_uri() . '/assets/images/about/how-we-work/icons/arrow.svg';
?>

<section class="hww-section">
    <div class="hww-wrapper">
        <!-- Background Image (includes decorative ribbons) -->
        <div class="hww-bg">
            <img src="<?php echo esc_url($bg_image); ?>" alt="" loading="lazy">
        </div>

        <!-- Content Container -->
        <div class="hww-container">
            <div class="hww-content">
                <!-- Header -->
                <div class="hww-header animate-on-scroll">
                    <h2 class="hww-title"><?php echo esc_html($title); ?></h2>
                    <p class="hww-subtitle"><?php echo esc_html($subtitle); ?></p>
                </div>

                <!-- Steps Cards -->
                <div class="hww-steps animate-stagger">
                    <?php foreach ($steps as $index => $step): 
                        $icon_url = is_array($step) && isset($step['icon']) 
                            ? (is_array($step['icon']) ? $step['icon']['url'] : $step['icon'])
                            : '';
                        $step_text = is_array($step) && isset($step['text']) ? $step['text'] : '';
                    ?>
                    <div class="hww-step animate-child">
                        <div class="hww-step__card">
                            <?php if ($icon_url): ?>
                            <img src="<?php echo esc_url($icon_url); ?>" alt="" class="hww-step__icon">
                            <?php endif; ?>
                            <span class="hww-step__text"><?php echo esc_html($step_text); ?></span>
                        </div>
                        <?php if ($index < count($steps) - 1): ?>
                        <div class="hww-step__arrow">
                            <img src="<?php echo esc_url($arrow_icon); ?>" alt="" class="hww-step__arrow-icon">
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
