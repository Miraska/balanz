<?php
/**
 * About Hero Section
 * 
 * @package Balanz
 */

$title = get_field('about_hero_title') ?: 'We believe in balance, not extremes';
$image = get_field('about_hero_image');
?>

<section class="about-hero">
    <div class="about-hero-container">
        <div class="about-hero-content animate-on-scroll">
            <h1 class="about-hero-title"><?php echo esc_html($title); ?></h1>
        </div>
    </div>
    
    <?php if ($image): ?>
    <div class="about-hero-image">
        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
    </div>
    <?php endif; ?>
</section>
