<?php
/**
 * Hero Section - What is Balanz
 * 
 * @package Balanz
 */

// ACF Fields
$title = get_field('hero_title') ?: 'What is Balanz';
$description = get_field('hero_description') ?: 'Balanz is a smart food service designed for busy people — helping you eat well, stay balanced, and live with more ease every day.';
$programs = get_field('programs'); // Repeater
$background = get_field('hero_background');
$button_text = get_field('hero_button_text') ?: 'Download App';
$bg_url = $background ? $background['url'] : BALANZ_THEME_URI . '/assets/images/hero-bg.jpg';
?>

<section class="hero-section" id="hero">
    <!-- Background Image + Content Over Background -->
    <div class="hero-bg">
        <img src="<?php echo esc_url($bg_url); ?>" alt="">
        
        <!-- Content Over Background -->
        <div class="hero-container">
            
            <!-- Hero Header -->
            <header class="hero-header">
            <h1 class="hero-title animate-on-scroll"><?php echo esc_html($title); ?></h1>
            <?php if ($description): ?>
            <p class="hero-description animate-on-scroll"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </header>
        
        <!-- Programs Grid -->
        <div class="hero-programs">
            <div class="programs-grid animate-stagger" id="programsGrid">
                <?php 
                if ($programs):
                    foreach ($programs as $index => $program): 
                ?>
                <div class="program-card animate-child" data-program="<?php echo esc_attr($index); ?>">
                    <div class="program-kals">
                        <svg class="icon-bolt" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                        <span><?php echo esc_html($program['calories']); ?></span>
                    </div>
                    
                    <?php if ($program['image']): ?>
                    <div class="program-image">
                        <img src="<?php echo esc_url($program['image']['url']); ?>" 
                             alt="<?php echo esc_attr($program['title']); ?>">
                    </div>
                    <?php endif; ?>
                    
                    <h3 class="program-title"><?php echo esc_html($program['title']); ?></h3>
                    <p class="program-description"><?php echo esc_html($program['subtitle']); ?></p>
                </div>
                <?php 
                    endforeach;
                else:
                    // Default programs if ACF not set
                    $default_programs = [
                        ['kals' => '1400 - 1600 Kals', 'title' => 'SHAPE', 'desc' => 'For Figure', 'special' => false],
                        ['kals' => '1700 - 1900 Kals', 'title' => 'BALANCE', 'desc' => 'Universal Nutrition', 'special' => false],
                        ['kals' => '2100 - 2300 Kals', 'title' => 'POWER', 'desc' => 'For Energy and Mass Gain', 'special' => false],
                        ['kals' => 'Unlimited Kals', 'title' => 'FREE', 'desc' => 'Unbound by Calorie Limits', 'special' => true],
                    ];
                    foreach ($default_programs as $index => $program):
                        $card_class = $program['special'] ? 'program-card program-card-special' : 'program-card';
                ?>
                <div class="<?php echo esc_attr($card_class); ?> animate-child" data-program="<?php echo esc_attr($index); ?>">
                    <div class="program-kals">
                        <svg class="icon-bolt" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                        <span><?php echo esc_html($program['kals']); ?></span>
                    </div>
                    <div class="program-image">
                        <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/program-' . ($index + 1) . '.jpg'); ?>" 
                             alt="<?php echo esc_attr($program['title']); ?>">
                    </div>
                    <h3 class="program-title"><?php echo esc_html($program['title']); ?></h3>
                    <p class="program-description"><?php echo esc_html($program['desc']); ?></p>
                </div>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
        </div>
        
        <!-- Hero CTA -->
        <div class="hero-cta">
            <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn btn-primary btn-download">
                <?php echo esc_html($button_text); ?>
            </a>
        </div>
        
    </div>
</section>
