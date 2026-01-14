<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    
    <!-- Header -->
    <header class="site-header" id="siteHeader">
        <div class="header-inner">
            <!-- Logo -->
            <a href="<?php echo home_url('/'); ?>" class="header-logo">
                <img class="logo-left" src="<?php echo BALANZ_THEME_URI; ?>/assets/images/logo/logo.svg" alt="Balanz Logo">
                <img class="logo-right" src="<?php echo BALANZ_THEME_URI; ?>/assets/images/logo/logo-02.svg" alt="Balanz Logo">
            </a>
            
            <div class="header-right">
                          <!-- Desktop Navigation -->
            <nav class="header-nav">
                <ul class="nav-list">
                    <li>
                        <a href="<?php echo home_url('/'); ?>" class="nav-link <?php echo is_front_page() ? 'is-active' : ''; ?>">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo get_permalink(get_page_by_path('about-us')); ?>" class="nav-link <?php echo is_page('about-us') ? 'is-active' : ''; ?>">
                            About Us
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Header Actions -->
            <div class="header-actions">
                <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn-download-app">
                    <span>Download App</span>
                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/download.svg" alt="Download Icon">
                </a>
                
                <!-- Mobile Menu Toggle -->
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/menu.svg" alt="Menu Icon">
                </button>
            </div>
            </div>

        </div>
    </header>
    
    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobileMenu">
        <ul class="mobile-nav-list">
            <li>
                <a href="<?php echo home_url('/'); ?>" class="mobile-nav-link <?php echo is_front_page() ? 'is-active' : ''; ?>">
                    Home
                </a>
            </li>
            <li>
                <a href="<?php echo get_permalink(get_page_by_path('about-us')); ?>" class="mobile-nav-link <?php echo is_page('about-us') ? 'is-active' : ''; ?>">
                    About Us
                </a>
            </li>
        </ul>
        <div class="mobile-menu-actions">
            <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn-download-app" style="margin-top: 24px">
                <span>Download App</span>
                <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/icons/download.svg" alt="Download Icon">
            </a>
        </div>
    </nav>

    <main id="main" class="site-main">
