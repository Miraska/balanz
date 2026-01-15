<?php
/**
 * App Screens Section - Manage Your Balance
 * Interactive prototype-like section with clickable features
 * 
 * @package Balanz
 */

$assets_uri = get_template_directory_uri() . '/assets/images/app-screens';
?>

<section class="app-section" id="app-screens">
    <div class="app-container">
        
        <!-- Section Header -->
        <header class="app-header">
            <h2 class="app-title">Manage your balance in a<br>convenient app</h2>
            <p class="app-description">Everything you need to plan, track, and manage your meals<br>— all in one place.</p>
        </header>
        
        <!-- Interactive App Showcase -->
        <div class="app-showcase" data-active-screen="1">
            
            <!-- Left Features -->
            <div class="app-features features-left">
                <!-- Screen 1 Features -->
                <div class="feature-group screen-1-features active">
                    <button class="app-feature-btn" data-screen="1" data-feature="build">
                        <img src="<?php echo $assets_uri; ?>/build-menu.svg" alt="Build your menu" class="feature-card">
                    </button>
                    <button class="app-feature-btn" data-screen="1" data-feature="browse">
                        <img src="<?php echo $assets_uri; ?>/browse.svg" alt="Browse dishes" class="feature-card">
                    </button>
                </div>
                
                <!-- Screen 2 Features -->
                <div class="feature-group screen-2-features">
                    <button class="app-feature-btn single" data-screen="2" data-feature="categories">
                        <span class="feature-badge yellow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="8" cy="8" r="2" fill="currentColor"/>
                                <circle cx="16" cy="8" r="2" fill="currentColor"/>
                                <circle cx="8" cy="16" r="2" fill="currentColor"/>
                                <circle cx="16" cy="16" r="2" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="feature-label">Food by<br>categories</span>
                    </button>
                </div>
                
                <!-- Screen 3 Features -->
                <div class="feature-group screen-3-features">
                    <button class="app-feature-btn single" data-screen="3" data-feature="orders">
                        <span class="feature-badge red">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="4" y="6" width="16" height="14" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <path d="M8 10h8M8 14h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="feature-label">Order<br>Detail</span>
                    </button>
                </div>
            </div>
            
            <!-- Phone Mockup -->
            <div class="app-phone-wrapper">
                <div class="app-phone">
                    <!-- Screen 1 -->
                    <div class="phone-screen active" data-screen="1">
                        <img src="<?php echo $assets_uri; ?>/phone-01.png" alt="Build your menu screen" loading="lazy">
                    </div>
                    
                    <!-- Screen 2 -->
                    <div class="phone-screen" data-screen="2">
                        <img src="<?php echo $assets_uri; ?>/phone-02.png" alt="Browse categories screen" loading="lazy">
                    </div>
                    
                    <!-- Screen 3 -->
                    <div class="phone-screen" data-screen="3">
                        <img src="<?php echo $assets_uri; ?>/phone-03.png" alt="Order tracking screen" loading="lazy">
                    </div>
                </div>
                
                <!-- Dashed Arrows -->
                <div class="arrow-connections">
                    <!-- Screen 1 Arrows -->
                    <svg class="dashed-arrow arrow-top-left screen-1-arrow" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 20 30 Q 80 10, 180 60" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 175 57 L 180 60 L 177 64" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <svg class="dashed-arrow arrow-bottom-left screen-1-arrow" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 20 90 Q 80 110, 180 60" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 175 63 L 180 60 L 177 57" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <svg class="dashed-arrow arrow-top-right screen-1-arrow" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 180 30 Q 120 10, 20 60" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 25 57 L 20 60 L 23 64" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <svg class="dashed-arrow arrow-bottom-right screen-1-arrow" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 180 90 Q 120 110, 20 60" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 25 63 L 20 60 L 23 57" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <!-- Screen 2 Arrows -->
                    <svg class="dashed-arrow arrow-left-straight screen-2-arrow" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 20 40 L 180 40" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 175 37 L 180 40 L 175 43" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <svg class="dashed-arrow arrow-right-straight screen-2-arrow" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 180 40 L 20 40" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 25 37 L 20 40 L 25 43" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <!-- Screen 3 Arrows -->
                    <svg class="dashed-arrow arrow-left-straight screen-3-arrow" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 20 40 L 180 40" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 175 37 L 180 40 L 175 43" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                    
                    <svg class="dashed-arrow arrow-right-straight screen-3-arrow" viewBox="0 0 200 80" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 180 40 L 20 40" stroke="#D1D5DB" stroke-width="2" stroke-dasharray="6,6" fill="none"/>
                        <path d="M 25 37 L 20 40 L 25 43" stroke="#D1D5DB" stroke-width="2" fill="none"/>
                    </svg>
                </div>
            </div>
            
            <!-- Right Features -->
            <div class="app-features features-right">
                <!-- Screen 1 Features -->
                <div class="feature-group screen-1-features active">
                    <button class="app-feature-btn" data-screen="1" data-feature="daily">
                        <img src="<?php echo $assets_uri; ?>/daily-plan.svg" alt="Daily Kals Plan" class="feature-card">
                    </button>
                    <button class="app-feature-btn" data-screen="1" data-feature="prepared">
                        <img src="<?php echo $assets_uri; ?>/prepared.svg" alt="Prepared Set" class="feature-card">
                    </button>
                </div>
                
                <!-- Screen 2 Features -->
                <div class="feature-group screen-2-features">
                    <button class="app-feature-btn single" data-screen="2" data-feature="calories">
                        <span class="feature-label">Calories<br>Counter</span>
                        <span class="feature-badge red">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M13 2L3 14h8l-2 8 10-12h-8l2-8z" fill="currentColor"/>
                            </svg>
                        </span>
                    </button>
                </div>
                
                <!-- Screen 3 Features -->
                <div class="feature-group screen-3-features">
                    <button class="app-feature-btn single" data-screen="3" data-feature="tracking">
                        <span class="feature-label">Time<br>Tracking</span>
                        <span class="feature-badge yellow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect x="5" y="4" width="14" height="16" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <line x1="9" y1="2" x2="9" y2="6" stroke="currentColor" stroke-width="1.5"/>
                                <line x1="15" y1="2" x2="15" y2="6" stroke="currentColor" stroke-width="1.5"/>
                                <line x1="5" y1="9" x2="19" y2="9" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
            
        </div>
        
        <!-- Navigation Controls -->
        <div class="app-navigation">
            <button class="app-nav-btn prev-btn" aria-label="Previous screen">
                <img src="<?php echo $assets_uri; ?>/left-button.svg" alt="Previous">
            </button>
            <button class="app-nav-btn next-btn" aria-label="Next screen">
                <img src="<?php echo $assets_uri; ?>/right-button.svg" alt="Next">
            </button>
        </div>
        
    </div>
</section>
