<?php
/**
 * Theme Setup & Activation
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
    
    // Create Home page if it doesn't exist
    $home_page = get_page_by_path('home');
    if (!$home_page) {
        $home_page_id = wp_insert_post([
            'post_title'    => 'Home',
            'post_name'     => 'home',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'front-page.php'
        ]);
        
        // Set as front page
        if ($home_page_id && !is_wp_error($home_page_id)) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page_id);
        }
    } else {
        // If Home page exists but not set as front page
        $current_front = get_option('page_on_front');
        if (!$current_front) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page->ID);
        }
    }
    
    // Create About Us page if it doesn't exist
    $about_page = get_page_by_path('about-us');
    if (!$about_page) {
        wp_insert_post([
            'post_title'    => 'About Us',
            'post_name'     => 'about-us',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'page-about-us.php'
        ]);
    }
    
    // Set permalink structure
    update_option('permalink_structure', '/%postname%/');
    flush_rewrite_rules();
    
    // Delete default comment
    wp_delete_comment(1, true);
}
add_action('after_switch_theme', 'balanz_theme_activation');

/**
 * Ensure Home page exists and is set as front page
 * Runs once after theme setup
 */
function balanz_ensure_home_page() {
    // Only run once
    if (get_option('balanz_home_page_created')) {
        return;
    }
    
    // Check if Home page exists
    $home_page = get_page_by_path('home');
    
    if (!$home_page) {
        // Create Home page
        $home_page_id = wp_insert_post([
            'post_title'    => 'Home',
            'post_name'     => 'home',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => get_current_user_id() ?: 1,
            'page_template' => 'front-page.php'
        ]);
        
        if ($home_page_id && !is_wp_error($home_page_id)) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page_id);
        }
    } else {
        // If Home page exists, make sure it's set as front page
        $current_front = get_option('page_on_front');
        if (!$current_front || $current_front != $home_page->ID) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page->ID);
        }
    }
    
    // Mark as done
    update_option('balanz_home_page_created', true);
}
add_action('admin_init', 'balanz_ensure_home_page');

/**
 * Custom Image Sizes
 */
add_action('after_setup_theme', function() {
    add_image_size('program-card', 240, 240, true);
    add_image_size('testimonial', 400, 400, true);
    add_image_size('hero-image', 800, 800, false);
});
