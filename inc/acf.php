<?php
/**
 * ACF Configuration & Options Pages
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
 * Note: Requires ACF Pro for Options Pages functionality
 * Using acf/init hook to ensure ACF is fully loaded
 */
function balanz_acf_options_pages() {
    // Check if ACF Pro is installed (free version doesn't have this function)
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    
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

    // Form Settings
    acf_add_options_sub_page([
        'page_title' => 'Form Settings',
        'menu_title' => 'Form Settings',
        'parent_slug' => 'theme-settings',
    ]);

    // SEO Settings
    acf_add_options_sub_page([
        'page_title' => 'SEO Settings',
        'menu_title' => 'SEO Settings',
        'parent_slug' => 'theme-settings',
    ]);

    // General Content (Header, Footer, etc.)
    acf_add_options_sub_page([
        'page_title' => 'General Content',
        'menu_title' => 'General Content',
        'parent_slug' => 'theme-settings',
    ]);
}
add_action('acf/init', 'balanz_acf_options_pages');
