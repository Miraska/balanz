<?php
/**
 * App Screens Section - Manage Your Balance
 * 
 * @package Balanz
 */

$title = get_field('app_title') ?: 'Manage your balance in a convenient app';
$description = get_field('app_description');
$screens = get_field('app_screens'); // Repeater with screen images
?>

<section class="app-section" id="app-screens">
    <div class="app-container">
        
        <!-- Section Header -->
        <header class="app-header animate-on-scroll">
            <h2 class="app-title"><?php echo esc_html($title); ?></h2>
            <?php if ($description): ?>
            <p class="app-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </header>
        
        <!-- Interactive Screens -->
        <div class="app-screens-wrapper animate-on-scroll">
            <div class="app-screens">
                
                <!-- Left Navigation -->
                <div class="app-nav-items nav-left">
                    <button class="app-nav-item" data-screen="menu">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/>
                        </svg>
                        <span class="nav-text">Build your menu</span>
                    </button>
                    <button class="app-nav-item" data-screen="dishes">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M8 12h8M12 8v8"/>
                        </svg>
                        <span class="nav-text">Browse dishes</span>
                    </button>
                </div>
                
                <!-- Phone Mockup -->
                <div class="app-phone">
                    <div class="app-phone-frame">
                        <div class="app-phone-screen" id="appPhoneScreen">
                            <?php 
                            if ($screens):
                                foreach ($screens as $index => $screen):
                            ?>
                            <img src="<?php echo esc_url($screen['image']['url']); ?>" 
                                 alt="<?php echo esc_attr($screen['label']); ?>"
                                 class="<?php echo $index === 0 ? 'is-active' : 'is-hidden'; ?>"
                                 data-screen="<?php echo sanitize_title($screen['label']); ?>">
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/app-screen-1.png" alt="App Screen" class="is-active" data-screen="menu">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/app-screen-2.png" alt="App Screen" class="is-hidden" data-screen="dishes">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/app-screen-3.png" alt="App Screen" class="is-hidden" data-screen="daily">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/app-screen-4.png" alt="App Screen" class="is-hidden" data-screen="prepared">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Right Navigation -->
                <div class="app-nav-items nav-right">
                    <button class="app-nav-item" data-screen="daily">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <span class="nav-text">Daily Kals Plan</span>
                    </button>
                    <button class="app-nav-item" data-screen="prepared">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                        </svg>
                        <span class="nav-text">Prepared list</span>
                    </button>
                </div>
                
            </div>
            
            <!-- Arrow decorations -->
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/arrow-left.svg" alt="" class="app-arrow arrow-left">
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/arrow-right.svg" alt="" class="app-arrow arrow-right">
        </div>
        
    </div>
</section>
