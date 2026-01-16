<?php
/**
 * Balanz Theme Functions
 * 
 * @package Balanz
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('BALANZ_VERSION', '1.0.0');
define('BALANZ_THEME_DIR', get_template_directory());
define('BALANZ_THEME_URI', get_template_directory_uri());
define('BALANZ_ASSETS_URI', BALANZ_THEME_URI . '/assets/dist');

/**
 * Theme Setup
 */
function balanz_theme_setup() {
    // Document title
    add_theme_support('title-tag');
    
    // Post thumbnails
    add_theme_support('post-thumbnails');
    
    // HTML5 markup
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ]);
    
    // Disable Gutenberg for pages (we use ACF)
    add_filter('use_block_editor_for_post', '__return_false');
}
add_action('after_setup_theme', 'balanz_theme_setup');

/**
 * Theme Activation - Create required pages and clean up defaults
 */
function balanz_theme_activation() {
    // Delete default "Hello World" post
    $default_post = get_page_by_path('hello-world', OBJECT, 'post');
    if ($default_post) {
        wp_delete_post($default_post->ID, true);
    }
    
    // Delete default "Sample Page"
    $sample_page = get_page_by_path('sample-page');
    if ($sample_page) {
        wp_delete_post($sample_page->ID, true);
    }
    
    // Create About Us page if it doesn't exist
    $about_page = get_page_by_path('about-us');
    if (!$about_page) {
        $about_page_id = wp_insert_post([
            'post_title'    => 'About Us',
            'post_name'     => 'about-us',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'page-about-us.php'
        ]);
        
        if ($about_page_id) {
            error_log('Balanz: About Us page created successfully');
        }
    }
    
    // Set permalink structure
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules();
    
    // Delete default comment
    wp_delete_comment(1, true);
    
    error_log('Balanz Theme: Activation completed');
}
add_action('after_switch_theme', 'balanz_theme_activation');

/**
 * Enqueue Assets
 */
function balanz_enqueue_assets() {
    // Main CSS
    wp_enqueue_style(
        'balanz-main',
        BALANZ_ASSETS_URI . '/css/main.css',
        [],
        BALANZ_VERSION
    );
    
    // Main JS
    wp_enqueue_script(
        'balanz-main',
        BALANZ_ASSETS_URI . '/js/main.js',
        [],
        BALANZ_VERSION,
        true
    );
    
    // Pass data to JS
    wp_localize_script('balanz-main', 'balanzData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('balanz_nonce'),
        'themeUrl' => BALANZ_THEME_URI
    ]);
}
add_action('wp_enqueue_scripts', 'balanz_enqueue_assets');

/**
 * ACF JSON Save/Load
 */
add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

/**
 * ACF Options Pages
 */
if (function_exists('acf_add_options_page')) {
    // Main Settings Page
    acf_add_options_page([
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-generic',
        'position' => 60,
        'redirect' => false
    ]);
    
    // App Links
    acf_add_options_sub_page([
        'page_title' => 'App Links',
        'menu_title' => 'App Links',
        'parent_slug' => 'theme-settings',
    ]);
    
    // Contact Info
    acf_add_options_sub_page([
        'page_title' => 'Contact Info',
        'menu_title' => 'Contact Info',
        'parent_slug' => 'theme-settings',
    ]);
    
    // Social Links
    acf_add_options_sub_page([
        'page_title' => 'Social Links',
        'menu_title' => 'Social Links',
        'parent_slug' => 'theme-settings',
    ]);
}

/**
 * Performance Optimizations
 */
// Remove emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove WP version
remove_action('wp_head', 'wp_generator');

// Remove jQuery Migrate
function balanz_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'balanz_remove_jquery_migrate');

/**
 * Security
 */
// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Restrict REST API to logged in users (optional)
// add_filter('rest_authentication_errors', function($result) {
//     if (!is_user_logged_in()) {
//         return new WP_Error('rest_disabled', 'REST API disabled', ['status' => 401]);
//     }
//     return $result;
// });

/**
 * Custom Image Sizes
 */
add_action('after_setup_theme', function() {
    add_image_size('program-card', 240, 240, true);
    add_image_size('testimonial', 400, 400, true);
    add_image_size('hero-image', 800, 800, false);
});

/**
 * Allow SVG uploads
 */
function balanz_allow_svg($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'balanz_allow_svg');

/**
 * Clean up WordPress head
 */
function balanz_clean_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
}
add_action('init', 'balanz_clean_head');
