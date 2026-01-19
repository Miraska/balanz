<?php
/**
 * Theme Header
 * 
 * @package Balanz
 */

// Get editable content from ACF options
$nav_home_text = get_field('nav_home_text', 'option') ?: 'Home';
$nav_about_text = get_field('nav_about_text', 'option') ?: 'About Us';
$download_btn_text = get_field('download_button_text', 'option') ?: 'Download App';
$site_name = get_bloginfo('name');

// Get About Us page URL dynamically
$about_page = get_page_by_path('about-us');
$about_url = $about_page ? get_permalink($about_page->ID) : home_url('/about-us/');

// Logo from ACF or default
$logo_main = get_field('site_logo', 'option');
$logo_secondary = get_field('site_logo_secondary', 'option');
$logo_main_url = $logo_main ? esc_url($logo_main['url']) : BALANZ_THEME_URI . '/assets/images/logo/logo.svg';
$logo_secondary_url = $logo_secondary ? esc_url($logo_secondary['url']) : BALANZ_THEME_URI . '/assets/images/logo/logo-02.svg';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Theme Color for mobile browsers -->
    <meta name="theme-color" content="#000000">
    <meta name="msapplication-TileColor" content="#000000">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    
    <!-- Header -->
    <header class="site-header" id="siteHeader">
        <div class="header-inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="header-logo" aria-label="<?php echo esc_attr($site_name); ?> - Home">
                <img class="logo-left" src="<?php echo $logo_main_url; ?>" alt="<?php echo esc_attr($site_name); ?> Logo">
                <img class="logo-right" src="<?php echo $logo_secondary_url; ?>" alt="<?php echo esc_attr($site_name); ?>">
            </a>
            
            <div class="header-right">
                <!-- Desktop Navigation -->
                <nav class="header-nav" aria-label="Main navigation">
                    <ul class="nav-list">
                        <li>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link <?php echo is_front_page() ? 'is-active' : ''; ?>">
                                <?php echo esc_html($nav_home_text); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url($about_url); ?>" class="nav-link <?php echo is_page('about-us') ? 'is-active' : ''; ?>">
                                <?php echo esc_html($nav_about_text); ?>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Header Actions -->
                <div class="header-actions">
                    <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn-download-app">
                        <span><?php echo esc_html($download_btn_text); ?></span>
                        <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/icons/download.svg'); ?>" alt="" aria-hidden="true">
                    </a>
                    
                    <!-- Mobile Menu Toggle -->
                    <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu">
                        <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/icons/menu.svg'); ?>" alt="" aria-hidden="true">
                    </button>
                </div>
            </div>

        </div>
    </header>
    
    <!-- Mobile Menu -->
    <nav class="mobile-menu" id="mobileMenu" aria-label="Mobile navigation">
        <ul class="mobile-nav-list">
            <li>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="mobile-nav-link <?php echo is_front_page() ? 'is-active' : ''; ?>">
                    <?php echo esc_html($nav_home_text); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo esc_url($about_url); ?>" class="mobile-nav-link <?php echo is_page('about-us') ? 'is-active' : ''; ?>">
                    <?php echo esc_html($nav_about_text); ?>
                </a>
            </li>
        </ul>
        <div class="mobile-menu-actions">
            <a href="<?php echo esc_url(get_field('download_link', 'option') ?: '#'); ?>" class="btn-download-app" style="margin-top: 24px">
                <span><?php echo esc_html($download_btn_text); ?></span>
                <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/icons/download.svg'); ?>" alt="" aria-hidden="true">
            </a>
        </div>
    </nav>

    <main id="main" class="site-main">
