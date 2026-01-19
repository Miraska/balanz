<?php
/**
 * Balanz Theme Functions
 * 
 * This file loads all theme modules from the inc/ directory.
 * Each module handles a specific aspect of the theme functionality.
 * 
 * @package Balanz
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// THEME CONSTANTS
// ============================================

define('BALANZ_VERSION', '1.0.0');
define('BALANZ_THEME_DIR', get_template_directory());
define('BALANZ_THEME_URI', get_template_directory_uri());
define('BALANZ_ASSETS_URI', BALANZ_THEME_URI . '/assets/dist');

// ============================================
// LOAD THEME MODULES
// ============================================

/**
 * Theme modules organized by functionality:
 * 
 * - setup.php    : Theme setup, activation, image sizes
 * - assets.php   : Scripts, styles, fonts loading
 * - acf.php      : ACF configuration and options pages
 * - seo.php      : Meta tags, Open Graph, sitemap, robots
 * - images.php   : Image optimization, WebP, lazy loading
 * - forms.php    : Contact form, AJAX, SMTP, submissions
 * - admin.php    : Admin dashboard, menus, branding
 * - security.php : Security headers, cleanup, protection
 * - helpers.php  : Helper functions for templates
 */

// Core setup and activation
require_once BALANZ_THEME_DIR . '/inc/setup.php';

// Assets (scripts, styles, fonts)
require_once BALANZ_THEME_DIR . '/inc/assets.php';

// ACF configuration
require_once BALANZ_THEME_DIR . '/inc/acf.php';

// SEO (meta tags, sitemap, robots)
require_once BALANZ_THEME_DIR . '/inc/seo.php';

// Image optimization
require_once BALANZ_THEME_DIR . '/inc/images.php';

// Forms handling
require_once BALANZ_THEME_DIR . '/inc/forms.php';

// Admin customizations
require_once BALANZ_THEME_DIR . '/inc/admin.php';

// Security features
require_once BALANZ_THEME_DIR . '/inc/security.php';

// Helper functions
require_once BALANZ_THEME_DIR . '/inc/helpers.php';
