<?php
/**
 * App Screens Section - Manage Your Balance
 * Interactive prototype-like section with clickable features
 * 
 * @package Balanz
 */

$assets_uri = get_template_directory_uri() . '/assets/images/app-screens';

// ACF Fields
$title = get_field('app_screens_title') ?: 'Manage your balance in a<br>convenient app';
$description = get_field('app_screens_description') ?: 'Everything you need to plan, track, and manage your meals<br>— all in one place.';

// Custom app screenshots
$screen_1 = get_field('app_screen_1');
$screen_2 = get_field('app_screen_2');
$screen_3 = get_field('app_screen_3');
$screen_1_url = $screen_1 ? $screen_1['url'] : $assets_uri . '/phone-01.png';
$screen_2_url = $screen_2 ? $screen_2['url'] : $assets_uri . '/phone-02.png';
$screen_3_url = $screen_3 ? $screen_3['url'] : $assets_uri . '/phone-03.png';
?>

<section class="app-section" id="app-screens">
    <div class="app-container">
        
      <div class="app-section-inner">
      
      <header class="app-header">
        <h2 class="app-title"><?php echo wp_kses_post($title); ?></h2>
        <p class="app-description"><?php echo wp_kses_post($description); ?></p>
      </header>
      
        <div class="app-showcase" data-active-screen="1">
            
            <!-- Phone Mockup -->
            <div class="app-phone">
                <div class="phone-screen active" data-screen="1">
                    <img src="<?php echo esc_url($screen_1_url); ?>" alt="Build your menu screen" loading="lazy">
                </div>
                <div class="phone-screen" data-screen="2">
                    <img src="<?php echo esc_url($screen_2_url); ?>" alt="Browse categories screen" loading="lazy">
                </div>
                <div class="phone-screen" data-screen="3">
                    <img src="<?php echo esc_url($screen_3_url); ?>" alt="Order tracking screen" loading="lazy">
                </div>
            </div>
            
            <!-- Screen 1 Cards 
                 Доступные классы для позиций:
                 - left-top, left-bottom (слева)
                 - right-top, right-bottom (справа)
                 Позиции настраиваются в _app-screens.scss
            -->
            <div class="screen-cards active" data-screen-cards="1">
                <button class="feature-card left-top" data-screen="1">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/build-menu.svg" alt="Build your menu" class="card-img">
                </button>
                
                <button class="feature-card left-bottom" data-screen="1">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/browse.svg" alt="Browse dishes" class="card-img">
                </button>
                
                <button class="feature-card right-top" data-screen="1">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/daily-plan.svg" alt="Daily Kals Plan" class="card-img">
                </button>
                
                <button class="feature-card right-bottom" data-screen="1">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/prepared.svg" alt="Prepared Set" class="card-img">
                </button>
            </div>
            
            <!-- Screen 2 Cards -->
            <div class="screen-cards" data-screen-cards="2">
                <button class="feature-card left-top" data-screen="2">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/build-menu.svg" alt="Build your menu" class="card-img">
                </button>
                
                <button class="feature-card right-top" data-screen="2">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/daily-plan.svg" alt="Daily Kals Plan" class="card-img">
                </button>
            </div>
            
            <!-- Screen 3 Cards -->
            <div class="screen-cards" data-screen-cards="3">
                <button class="feature-card left-bottom" data-screen="3">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/browse.svg" alt="Browse dishes" class="card-img">
                </button>
                
                <button class="feature-card right-bottom" data-screen="3">
                    <img src="<?php echo $assets_uri; ?>/vector-arrow.svg" alt="" class="arrow" aria-hidden="true">
                    <img src="<?php echo $assets_uri; ?>/prepared.svg" alt="Prepared Set" class="card-img">
                </button>
            </div>
            
        </div>
        
        <div class="app-navigation">
            <button class="app-nav-btn prev-btn" aria-label="Previous screen">
                <img src="<?php echo $assets_uri; ?>/left-button.svg" alt="Previous">
            </button>
            <button class="app-nav-btn next-btn" aria-label="Next screen">
                <img src="<?php echo $assets_uri; ?>/right-button.svg" alt="Next">
            </button>
        </div>

    </div>

        
    </div>
</section>
