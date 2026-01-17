<?php
/**
 * About Hero Section
 * 
 * @package Balanz
 */

$title = get_field('about_hero_title') ?: 'We believe in balance,<br>not extremes';
?>

<section class="about-hero-section" id="about-hero">
    <!-- Background Image -->
    <div class="about-hero-bg">
        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/about/hero/bg.jpg" alt="About Balanz">
        
        <!-- Content Over Background -->
        <div class="about-hero-container">
            <div class="about-hero-content">
                <h1 class="about-hero-title animate-on-scroll"><?php echo $title ?></h1>
            </div>
        </div>
    </div>
</section>
