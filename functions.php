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

/**
 * SEO Meta Tags and Open Graph
 * Priority: ACF fields > WordPress settings > hardcoded fallbacks
 */
function balanz_seo_meta_tags() {
    // Debug marker - if you see this in View Source, function is running
    echo "\n<!-- BALANZ_OG_START -->\n";
    
    // Get WordPress standard settings
    $site_name = get_bloginfo('name') ?: 'Balanz';
    $site_tagline = get_bloginfo('description');
    $site_url = home_url('/');
    
    // Hardcoded fallbacks (only if nothing else is set)
    $fallback_title = 'Balanz - Smart Food for Busy People';
    $fallback_description = 'Balanz is a smart food service designed for busy people — helping you eat well, stay balanced, and live with more ease every day.';
    
    // Check if ACF is active
    $acf_active = function_exists('get_field');
    
    // Initialize with WordPress settings (middle priority)
    $seo_title = $site_name;
    $seo_description = $site_tagline ?: $fallback_description;
    $twitter_username = '';
    
    // Try ACF global settings (higher priority than WP settings)
    if ($acf_active) {
        $acf_description = get_field('seo_default_description', 'option');
        if ($acf_description) {
            $seo_description = $acf_description;
        }
        $twitter_username = get_field('seo_twitter_username', 'option') ?: '';
    }
    
    // OG Image defaults
    $og_image_url = '';
    $og_image_width = 1200;
    $og_image_height = 630;
    $og_image_alt = $site_name;
    
    // Page-specific SEO
    if (is_front_page()) {
        // Home page - try ACF first, then WP settings, then fallback
        if ($acf_active) {
            $acf_title = get_field('seo_home_title', 'option');
            $acf_desc = get_field('seo_home_description', 'option');
            if ($acf_title) {
                $seo_title = $acf_title;
            } elseif ($site_tagline) {
                $seo_title = $site_name . ' - ' . $site_tagline;
            } else {
                $seo_title = $site_name ?: $fallback_title;
            }
            if ($acf_desc) {
                $seo_description = $acf_desc;
            }
        } else {
            // No ACF - use WP settings
            if ($site_tagline) {
                $seo_title = $site_name . ' - ' . $site_tagline;
            } else {
                $seo_title = $site_name ?: $fallback_title;
            }
        }
    } elseif (is_page()) {
        // Other pages
        $page_title = get_the_title();
        $seo_title = $page_title ? $page_title . ' - ' . $site_name : $site_name;
        
        if ($acf_active) {
            $page_seo_title = get_field('seo_title');
            $page_seo_description = get_field('seo_description');
            if ($page_seo_title) $seo_title = $page_seo_title;
            if ($page_seo_description) $seo_description = $page_seo_description;
        }
    } else {
        $post_title = get_the_title();
        $seo_title = $post_title ? $post_title . ' - ' . $site_name : $site_name;
    }
    
    // OG Image - priority: page ACF > global ACF > theme fallback > screenshot
    $og_image_found = false;
    
    if ($acf_active) {
        // Try page-specific OG image first
        $page_og_image = get_field('seo_og_image');
        if ($page_og_image && isset($page_og_image['url']) && !empty($page_og_image['url'])) {
            $og_image_url = $page_og_image['url'];
            $og_image_width = isset($page_og_image['width']) ? $page_og_image['width'] : 1200;
            $og_image_height = isset($page_og_image['height']) ? $page_og_image['height'] : 630;
            $og_image_alt = isset($page_og_image['alt']) && $page_og_image['alt'] ? $page_og_image['alt'] : $seo_title;
            $og_image_found = true;
        }
        
        // Try global OG image from Theme Settings > SEO Settings
        if (!$og_image_found) {
            $default_og_image_acf = get_field('seo_og_image', 'option');
            if ($default_og_image_acf && isset($default_og_image_acf['url']) && !empty($default_og_image_acf['url'])) {
                $og_image_url = $default_og_image_acf['url'];
                $og_image_width = isset($default_og_image_acf['width']) ? $default_og_image_acf['width'] : 1200;
                $og_image_height = isset($default_og_image_acf['height']) ? $default_og_image_acf['height'] : 630;
                $og_image_alt = isset($default_og_image_acf['alt']) && $default_og_image_acf['alt'] ? $default_og_image_acf['alt'] : $site_name;
                $og_image_found = true;
            }
        }
    }
    
    // Fallback to theme images (only if ACF image not set)
    if (!$og_image_found || empty($og_image_url)) {
        // Check if og-image.jpg exists in theme
        $og_image_path = BALANZ_THEME_DIR . '/assets/images/og-image.jpg';
        if (file_exists($og_image_path)) {
            $og_image_url = BALANZ_THEME_URI . '/assets/images/og-image.jpg';
        } else {
            // Final fallback to screenshot.png
            $og_image_url = BALANZ_THEME_URI . '/screenshot.png';
        }
        $og_image_alt = $site_name . ' Preview';
    }
    
    // Current URL (clean)
    $current_url = is_front_page() ? $site_url : get_permalink();
    if (!$current_url) {
        $current_url = home_url(add_query_arg([], $_SERVER['REQUEST_URI'] ?? ''));
    }
    
    // Ensure all values are not empty
    $seo_title = $seo_title ?: $fallback_title;
    $seo_description = $seo_description ?: $fallback_description;
    
    // Output meta tags
    ?>
    
    <!-- Balanz SEO Meta Tags -->
    <meta name="description" content="<?php echo esc_attr($seo_description); ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    
    <!-- Open Graph / Facebook / Telegram / VK -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url($current_url); ?>">
    <meta property="og:title" content="<?php echo esc_attr($seo_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($seo_description); ?>">
    <meta property="og:image" content="<?php echo esc_url($og_image_url); ?>">
    <meta property="og:image:secure_url" content="<?php echo esc_url($og_image_url); ?>">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="<?php echo esc_attr($og_image_width); ?>">
    <meta property="og:image:height" content="<?php echo esc_attr($og_image_height); ?>">
    <meta property="og:image:alt" content="<?php echo esc_attr($og_image_alt); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:locale" content="<?php echo esc_attr(str_replace('-', '_', get_locale())); ?>">
    
    <!-- Twitter / X -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo esc_url($current_url); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr($seo_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($seo_description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($og_image_url); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr($og_image_alt); ?>">
    <?php if ($twitter_username): ?>
    <meta name="twitter:site" content="@<?php echo esc_attr($twitter_username); ?>">
    <meta name="twitter:creator" content="@<?php echo esc_attr($twitter_username); ?>">
    <?php endif; ?>
    
    <!-- Additional SEO -->
    <link rel="canonical" href="<?php echo esc_url($current_url); ?>">
    
    <?php
    // Favicon
    $favicon_url = '';
    if ($acf_active) {
        $favicon = get_field('site_favicon', 'option');
        if ($favicon && isset($favicon['url'])) {
            $favicon_url = $favicon['url'];
        }
    }
    
    if ($favicon_url) {
        ?>
        <link rel="icon" type="image/png" href="<?php echo esc_url($favicon_url); ?>">
        <link rel="apple-touch-icon" href="<?php echo esc_url($favicon_url); ?>">
        <link rel="shortcut icon" href="<?php echo esc_url($favicon_url); ?>">
        <?php
    }
    
    echo "<!-- BALANZ_OG_END -->\n";
}
add_action('wp_head', 'balanz_seo_meta_tags', 1);

/**
 * Custom document title
 */
function balanz_document_title($title) {
    if (is_front_page()) {
        $custom_title = get_field('seo_home_title', 'option');
        if ($custom_title) {
            return $custom_title;
        }
    } elseif (is_page()) {
        $page_title = get_field('seo_title');
        if ($page_title) {
            return $page_title;
        }
    }
    return $title;
}
add_filter('pre_get_document_title', 'balanz_document_title');

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

/**
 * Save form submission to database/file (backup)
 * Only saves if WP_DEBUG is enabled or email fails
 */
function balanz_save_submission_to_file($data, $force = false) {
    // Only save in debug mode or when forced (email failed)
    if (!WP_DEBUG && !$force) {
        return false;
    }
    
    $upload_dir = wp_upload_dir();
    $submissions_file = $upload_dir['basedir'] . '/form-submissions.log';
    
    $entry = "\n" . str_repeat('=', 60) . "\n";
    $entry .= date('Y-m-d H:i:s') . "\n";
    $entry .= str_repeat('-', 60) . "\n";
    $entry .= "Name: " . $data['name'] . "\n";
    $entry .= "Contact: " . $data['contact'] . "\n";
    $entry .= "Message: " . $data['message'] . "\n";
    $entry .= "Subscribe: " . ($data['subscribe'] ? 'Yes' : 'No') . "\n";
    $entry .= "IP: " . balanz_get_client_ip() . "\n";
    $entry .= str_repeat('=', 60) . "\n";
    
    file_put_contents($submissions_file, $entry, FILE_APPEND);
    
    return $submissions_file;
}

/**
 * Configure SMTP for email sending
 * Alternative: use WP Mail SMTP plugin instead
 */
function balanz_configure_smtp($phpmailer) {
    // Only configure if not already using SMTP plugin
    if (defined('WPMS_ON') || defined('WP_MAIL_SMTP_VERSION')) {
        if (WP_DEBUG) {
            error_log('Balanz SMTP: Skipped - using WP Mail SMTP plugin');
        }
        return;
    }
    
    // Get SMTP settings from options (you can configure in Theme Settings)
    $smtp_host = get_field('smtp_host', 'option');
    $smtp_port = get_field('smtp_port', 'option') ?: 587;
    $smtp_user = get_field('smtp_username', 'option');
    $smtp_pass = get_field('smtp_password', 'option');
    $smtp_from = get_field('smtp_from_email', 'option');
    $smtp_from_name = get_field('smtp_from_name', 'option') ?: get_bloginfo('name');
    
    // If SMTP not configured in options, log warning and skip
    if (!$smtp_host || !$smtp_user || !$smtp_pass) {
        if (WP_DEBUG) {
            error_log('Balanz SMTP: NOT CONFIGURED! Go to Theme Settings → Form Settings');
            error_log('Balanz SMTP: Host=' . ($smtp_host ?: 'EMPTY') . ', User=' . ($smtp_user ?: 'EMPTY') . ', Pass=' . ($smtp_pass ? 'SET' : 'EMPTY'));
        }
        return;
    }
    
    // Enable debug in WP_DEBUG mode
    if (WP_DEBUG) {
        $phpmailer->SMTPDebug = 2;
        $phpmailer->Debugoutput = function($str, $level) {
            error_log("PHPMailer [$level]: $str");
        };
    }
    
    $phpmailer->isSMTP();
    $phpmailer->Host = $smtp_host;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = intval($smtp_port);
    $phpmailer->Username = $smtp_user;
    $phpmailer->Password = $smtp_pass;
    $phpmailer->SMTPSecure = intval($smtp_port) == 465 ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $phpmailer->From = $smtp_from ?: $smtp_user;
    $phpmailer->FromName = $smtp_from_name;
    
    if (WP_DEBUG) {
        error_log("Balanz SMTP: Configured - Host=$smtp_host, Port=$smtp_port, User=$smtp_user, From=" . ($smtp_from ?: $smtp_user));
    }
}
add_action('phpmailer_init', 'balanz_configure_smtp');

/**
 * Log email failures for debugging
 */
function balanz_log_mail_failure($wp_error) {
    if (WP_DEBUG && is_wp_error($wp_error)) {
        error_log('=== WP_MAIL FAILED ===');
        error_log('Error Code: ' . $wp_error->get_error_code());
        error_log('Error Message: ' . $wp_error->get_error_message());
        $error_data = $wp_error->get_error_data();
        if ($error_data) {
            error_log('Error Data: ' . print_r($error_data, true));
        }
        error_log('======================');
    }
}
add_action('wp_mail_failed', 'balanz_log_mail_failure');

/**
 * Share with Balanz - Contact Form AJAX Handler
 */
function balanz_handle_share_form() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'balanz_nonce')) {
        wp_send_json_error([
            'message' => 'Security check failed. Please refresh the page and try again.'
        ], 403);
    }
    
    // Sanitize and validate inputs
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $contact = isset($_POST['contact']) ? sanitize_text_field($_POST['contact']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $subscribe = isset($_POST['subscribe']) && $_POST['subscribe'] === 'true';
    
    // Validation errors
    $errors = [];
    
    // Name validation
    if (empty($name)) {
        $errors['name'] = 'Please enter your name.';
    } elseif (strlen($name) < 2) {
        $errors['name'] = 'Name must be at least 2 characters.';
    } elseif (strlen($name) > 100) {
        $errors['name'] = 'Name is too long.';
    }
    
    // Contact validation (email or phone)
    if (empty($contact)) {
        $errors['contact'] = 'Please enter your phone number or email.';
    } else {
        // Check if it's an email
        $is_email = filter_var($contact, FILTER_VALIDATE_EMAIL);
        
        // Check if it's a phone (basic validation - digits, spaces, +, -, parentheses)
        $phone_clean = preg_replace('/[\s\-\(\)\+]/', '', $contact);
        $is_phone = preg_match('/^[0-9]{7,15}$/', $phone_clean);
        
        if (!$is_email && !$is_phone) {
            $errors['contact'] = 'Please enter a valid email or phone number.';
        }
    }
    
    // Message validation (optional but check length if provided)
    if (!empty($message) && strlen($message) > 2000) {
        $errors['message'] = 'Message is too long (max 2000 characters).';
    }
    
    // Return errors if any
    if (!empty($errors)) {
        wp_send_json_error([
            'message' => 'Please fix the errors below.',
            'errors' => $errors
        ], 400);
    }
    
    // Get email from ACF options (configurable by admin)
    $to = get_field('form_recipient_email', 'option');
    if (empty($to) || !is_email($to)) {
        // Fallback to admin email if ACF field not set
        $to = get_option('admin_email');
    }
    
    $subject = 'Balanz: New message from ' . $name;
    
    // Build HTML email body (reduces spam score vs plain text)
    $email_body = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #1a1a1a; padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">New Contact Form Submission</h1>
                        </td>
                    </tr>
                    <!-- Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <strong style="color: #666;">Name:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . esc_html($name) . '</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <strong style="color: #666;">Contact:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . esc_html($contact) . '</span>
                                    </td>
                                </tr>';
    
    if (!empty($message)) {
        $email_body .= '
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                        <strong style="color: #666;">Message:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . nl2br(esc_html($message)) . '</span>
                                    </td>
                                </tr>';
    }
    
    $email_body .= '
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <strong style="color: #666;">Subscribe to tips:</strong><br>
                                        <span style="color: #333; font-size: 16px;">' . ($subscribe ? 'Yes' : 'No') . '</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #999;">
                            Sent from ' . esc_url(home_url()) . '<br>
                            ' . date_i18n('F j, Y \a\t g:i a') . '<br>
                            IP: ' . balanz_get_client_ip() . '
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
    
    // Get SMTP From settings (important: must match SMTP credentials domain!)
    $smtp_from = get_field('smtp_from_email', 'option');
    $smtp_from_name = get_field('smtp_from_name', 'option') ?: 'Balanz';
    
    // Use SMTP From if configured, otherwise fallback to site domain
    if ($smtp_from && is_email($smtp_from)) {
        $from_email = $smtp_from;
        $from_name = $smtp_from_name;
    } else {
        // Fallback - but this likely won't work without SMTP!
        $from_email = 'noreply@' . parse_url(home_url(), PHP_URL_HOST);
        $from_name = 'Balanz Website';
        
        if (WP_DEBUG) {
            error_log('Balanz Form: WARNING - No SMTP From email configured! Using fallback: ' . $from_email);
        }
    }
    
    // Email headers (HTML format reduces spam score)
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'X-Mailer: Balanz WordPress Theme',
    ];
    
    // Add reply-to if contact is email (so admin can reply directly)
    if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $contact . '>';
    }
    
    if (WP_DEBUG) {
        error_log('Balanz Form: Sending to=' . $to . ', from=' . $from_email);
    }
    
    // Prepare submission data
    $submission_data = [
        'name' => $name,
        'contact' => $contact,
        'message' => $message,
        'subscribe' => $subscribe
    ];
    
    // Save to file only in debug mode
    if (WP_DEBUG) {
        balanz_save_submission_to_file($submission_data);
    }
    
    // Save to file/database first (always, as backup)
    $log_file = balanz_save_submission_to_file($submission_data, true);
    
    // Try to send email
    $sent = wp_mail($to, $subject, $email_body, $headers);
    
    // Get last error if mail failed
    $mail_error = error_get_last();
    
    if ($sent) {
        // Log successful send
        if (WP_DEBUG) {
            error_log('Balanz Form: Email sent successfully to ' . $to);
        }
        
        wp_send_json_success([
            'message' => 'Thank you! Your message has been sent successfully.'
        ]);
    } else {
        // Log failure
        if (WP_DEBUG) {
            error_log('Balanz Form: Email failed to send. Error: ' . ($mail_error['message'] ?? 'Unknown'));
            error_log('Balanz Form: Saved to file: ' . $log_file);
        }
        
        // Still return success - form data is saved to file
        // Admin can check submissions in WordPress admin
        wp_send_json_success([
            'message' => 'Thank you! Your message has been received.',
            'debug' => WP_DEBUG ? [
                'email_sent' => false,
                'saved_to' => $log_file,
                'recipient' => $to,
                'error' => $mail_error['message'] ?? 'Email sending failed'
            ] : null
        ]);
    }
}
add_action('wp_ajax_balanz_share_form', 'balanz_handle_share_form');
add_action('wp_ajax_nopriv_balanz_share_form', 'balanz_handle_share_form');

/**
 * Test SMTP Settings - Send test email
 */
function balanz_send_test_email() {
    // Check admin permission
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $test_email = get_field('smtp_test_email', 'option');
    if (!$test_email || !is_email($test_email)) {
        return;
    }
    
    $subject = 'Test Email from Balanz Theme';
    $message = "This is a test email to verify your SMTP settings are working correctly.\n\n";
    $message .= "If you received this email, your SMTP configuration is successful!\n\n";
    $message .= "Sent from: " . home_url() . "\n";
    $message .= "Time: " . date('Y-m-d H:i:s');
    
    $sent = wp_mail($test_email, $subject, $message);
    
    if ($sent) {
        add_settings_error(
            'smtp_test',
            'smtp_test_success',
            'Test email sent successfully to ' . $test_email . '. Check your inbox!',
            'success'
        );
    } else {
        add_settings_error(
            'smtp_test',
            'smtp_test_error',
            'Failed to send test email. Please check your SMTP settings.',
            'error'
        );
    }
}

// Send test email when SMTP settings are saved
add_action('acf/save_post', function($post_id) {
    if ($post_id === 'options' && isset($_POST['acf']['field_5f9a1b2c3d9ec'])) {
        balanz_send_test_email();
    }
});

/**
 * Get client IP address
 */
function balanz_get_client_ip() {
    $ip_keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    
    foreach ($ip_keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = $_SERVER[$key];
            // Handle comma-separated IPs (from proxies)
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    
    return 'Unknown';
}

/**
 * Add admin page to view form submissions
 */
function balanz_add_submissions_menu() {
    add_menu_page(
        'Form Submissions',
        'Form Submissions',
        'manage_options',
        'balanz-submissions',
        'balanz_render_submissions_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'balanz_add_submissions_menu');

/**
 * Render submissions page
 */
function balanz_render_submissions_page() {
    $upload_dir = wp_upload_dir();
    $file = $upload_dir['basedir'] . '/form-submissions.log';
    
    echo '<div class="wrap">';
    echo '<h1>📧 Form Submissions</h1>';
    
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $file_size = size_format(filesize($file));
        $file_url = $upload_dir['baseurl'] . '/form-submissions.log';
        
        echo '<p><strong>File:</strong> ' . esc_html($file) . '</p>';
        echo '<p><strong>Size:</strong> ' . esc_html($file_size) . '</p>';
        echo '<p><a href="' . esc_url($file_url) . '" class="button" download>Download Log File</a></p>';
        
        echo '<hr>';
        
        if (!empty(trim($content))) {
            echo '<div style="background: #1e1e1e; color: #d4d4d4; padding: 20px; border-radius: 4px; overflow: auto; max-height: 80vh; font-family: monospace; font-size: 13px; line-height: 1.6;">';
            echo '<pre style="margin: 0; color: #d4d4d4;">' . esc_html($content) . '</pre>';
            echo '</div>';
        } else {
            echo '<p>No submissions yet.</p>';
        }
        
        // Clear log button
        if (!empty(trim($content))) {
            echo '<hr>';
            echo '<form method="post" style="margin-top: 20px;">';
            wp_nonce_field('balanz_clear_log', 'balanz_clear_log_nonce');
            echo '<button type="submit" name="clear_log" class="button button-secondary" onclick="return confirm(\'Are you sure you want to clear all submissions?\')">Clear All Submissions</button>';
            echo '</form>';
        }
    } else {
        echo '<div class="notice notice-warning"><p>No submissions file found yet. The file will be created automatically when someone submits the form.</p></div>';
        echo '<p><strong>Expected location:</strong> <code>' . esc_html($file) . '</code></p>';
    }
    
    echo '</div>';
    
    // Handle clear log action
    if (isset($_POST['clear_log']) && check_admin_referer('balanz_clear_log', 'balanz_clear_log_nonce')) {
        if (file_exists($file)) {
            unlink($file);
            echo '<div class="notice notice-success"><p>All submissions have been cleared.</p></div>';
            echo '<script>setTimeout(function(){ window.location.reload(); }, 1000);</script>';
        }
    }
}

// ============================================================================
// ADMIN CLEANUP & CLIENT-FRIENDLY IMPROVEMENTS
// ============================================================================

/**
 * Check if ACF PRO is installed and show admin notice if not
 */
function balanz_check_acf_requirement() {
    if (!function_exists('acf_add_options_page')) {
        add_action('admin_notices', function() {
            $class = 'notice notice-error';
            $message = sprintf(
                '<strong>Balanz Theme:</strong> This theme requires <a href="%s" target="_blank">Advanced Custom Fields PRO</a> plugin to manage content. Please install and activate it.',
                'https://www.advancedcustomfields.com/pro/'
            );
            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), $message);
        });
    }
}
add_action('admin_init', 'balanz_check_acf_requirement');

/**
 * Remove unnecessary admin menu items for cleaner experience
 * Keeps only what's needed for content management
 */
function balanz_clean_admin_menu() {
    // Remove Posts (not used - landing pages only)
    remove_menu_page('edit.php');
    
    // Remove Comments (not used)
    remove_menu_page('edit-comments.php');
    
    // Remove Tools (rarely needed)
    remove_menu_page('tools.php');
}
add_action('admin_menu', 'balanz_clean_admin_menu', 999);

/**
 * Remove unnecessary submenus under Appearance
 */
function balanz_clean_appearance_submenu() {
    global $submenu;
    
    // Remove Theme Editor (security risk)
    remove_submenu_page('themes.php', 'theme-editor.php');
    
    // Remove Themes page (prevent accidental theme changes)
    // Uncomment if you want to hide theme switcher from client:
    // remove_submenu_page('themes.php', 'themes.php');
    
    // Remove Customize (not used - we use ACF)
    remove_submenu_page('themes.php', 'customize.php?return=' . urlencode($_SERVER['REQUEST_URI']));
    
    // Remove Widgets (not used)
    remove_submenu_page('themes.php', 'widgets.php');
    
    // Remove Menus (we have hardcoded nav, but keep if needed)
    // remove_submenu_page('themes.php', 'nav-menus.php');
}
add_action('admin_menu', 'balanz_clean_appearance_submenu', 999);

/**
 * Disable Customizer completely
 */
function balanz_disable_customizer() {
    // Remove Customize from admin bar
    add_action('admin_bar_menu', function($wp_admin_bar) {
        $wp_admin_bar->remove_node('customize');
    }, 999);
    
    // Redirect Customizer to Dashboard
    add_action('load-customize.php', function() {
        wp_redirect(admin_url());
        exit;
    });
}
add_action('init', 'balanz_disable_customizer');

/**
 * Hide "Screen Options" and "Help" tabs for cleaner UI
 */
function balanz_hide_screen_options_and_help() {
    // Only hide for non-administrators (optional - you can remove the check)
    if (!current_user_can('manage_options')) {
        add_filter('screen_options_show_screen', '__return_false');
        add_action('admin_head', function() {
            echo '<style>#contextual-help-link-wrap { display: none !important; }</style>';
        });
    }
}
add_action('admin_init', 'balanz_hide_screen_options_and_help');

/**
 * Clean up admin bar
 */
function balanz_clean_admin_bar($wp_admin_bar) {
    // Remove WordPress logo and links
    $wp_admin_bar->remove_node('wp-logo');
    
    // Remove comments
    $wp_admin_bar->remove_node('comments');
    
    // Remove "New" dropdown items we don't use
    $wp_admin_bar->remove_node('new-post');
    $wp_admin_bar->remove_node('new-user');
    
    // Remove search (rarely used)
    $wp_admin_bar->remove_node('search');
}
add_action('admin_bar_menu', 'balanz_clean_admin_bar', 999);

/**
 * Customize admin footer text
 */
function balanz_admin_footer_text() {
    return '<span id="footer-thankyou">Balanz Theme &mdash; <a href="' . home_url('/') . '" target="_blank">View Site</a></span>';
}
add_filter('admin_footer_text', 'balanz_admin_footer_text');

/**
 * Remove WordPress version from footer
 */
add_filter('update_footer', '__return_empty_string', 11);

/**
 * Custom admin dashboard widgets
 */
function balanz_customize_dashboard() {
    global $wp_meta_boxes;
    
    // Remove default dashboard widgets
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
    
    // Remove plugin promo widgets
    remove_meta_box('dashboard_php_nag', 'dashboard', 'normal');
    
    // Add our custom welcome widget
    wp_add_dashboard_widget(
        'balanz_welcome_widget',
        'Welcome to Balanz',
        'balanz_welcome_widget_content'
    );
    
    // Add quick links widget
    wp_add_dashboard_widget(
        'balanz_quick_links',
        'Quick Links',
        'balanz_quick_links_content'
    );
}
add_action('wp_dashboard_setup', 'balanz_customize_dashboard');

/**
 * Welcome widget content
 */
function balanz_welcome_widget_content() {
    ?>
    <div style="padding: 10px 0;">
        <p style="font-size: 14px; line-height: 1.6;">
            Welcome to your Balanz website admin panel. Here you can manage all content, settings, and view form submissions.
        </p>
        <p style="margin-top: 15px;">
            <a href="<?php echo admin_url('admin.php?page=theme-settings'); ?>" class="button button-primary" style="margin-right: 10px;">
                Theme Settings
            </a>
            <a href="<?php echo home_url('/'); ?>" class="button" target="_blank">
                View Website
            </a>
        </p>
    </div>
    <?php
}

/**
 * Quick links widget content
 */
function balanz_quick_links_content() {
    $links = [
        ['url' => admin_url('post.php?post=' . get_option('page_on_front') . '&action=edit'), 'label' => 'Edit Home Page', 'icon' => '🏠'],
        ['url' => admin_url('edit.php?post_type=page'), 'label' => 'All Pages', 'icon' => '📄'],
        ['url' => admin_url('admin.php?page=theme-settings'), 'label' => 'Theme Settings', 'icon' => '⚙️'],
        ['url' => admin_url('admin.php?page=acf-options-general-content'), 'label' => 'Header & Footer', 'icon' => '🎨'],
        ['url' => admin_url('admin.php?page=acf-options-social-links'), 'label' => 'Social Links', 'icon' => '🔗'],
        ['url' => admin_url('admin.php?page=balanz-submissions'), 'label' => 'Form Submissions', 'icon' => '📧'],
    ];
    
    echo '<ul style="margin: 0; padding: 10px 0;">';
    foreach ($links as $link) {
        printf(
            '<li style="margin: 8px 0;"><a href="%s" style="text-decoration: none;">%s %s</a></li>',
            esc_url($link['url']),
            $link['icon'],
            esc_html($link['label'])
        );
    }
    echo '</ul>';
}

/**
 * Add custom admin CSS for branding
 */
function balanz_admin_styles() {
    ?>
    <style>
        /* Subtle branding */
        #adminmenu .wp-menu-image.dashicons-admin-generic:before {
            color: #00a0d2;
        }
        
        /* Highlight Theme Settings menu */
        #adminmenu li.toplevel_page_theme-settings .wp-menu-name {
            font-weight: 600;
        }
        
        /* Better dashboard widgets */
        #balanz_welcome_widget .inside,
        #balanz_quick_links .inside {
            padding: 12px;
        }
        
        /* Hide annoying notices for editors */
        <?php if (!current_user_can('manage_options')): ?>
        .notice:not(.balanz-notice),
        .update-nag {
            display: none !important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('admin_head', 'balanz_admin_styles');

/**
 * Redirect users to Dashboard after login (instead of profile)
 */
function balanz_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        return admin_url();
    }
    return $redirect_to;
}
add_filter('login_redirect', 'balanz_login_redirect', 10, 3);

/**
 * Simplify Pages list - remove unnecessary columns
 */
function balanz_pages_columns($columns) {
    unset($columns['comments']);
    unset($columns['author']);
    return $columns;
}
add_filter('manage_pages_columns', 'balanz_pages_columns');

/**
 * Disable automatic updates notifications for non-admins
 */
function balanz_hide_update_notices() {
    if (!current_user_can('update_core')) {
        remove_action('admin_notices', 'update_nag', 3);
        remove_action('admin_notices', 'maintenance_nag', 10);
    }
}
add_action('admin_head', 'balanz_hide_update_notices');

/**
 * Custom login page styling (optional branding)
 */
function balanz_login_styles() {
    ?>
    <style>
        body.login {
            background: #f0f0f1;
        }
        .login h1 a {
            background-image: url('<?php echo BALANZ_THEME_URI; ?>/assets/images/logo/logo.svg') !important;
            background-size: contain !important;
            width: 200px !important;
            height: 60px !important;
        }
        .login #backtoblog a,
        .login #nav a {
            color: #333 !important;
        }
    </style>
    <?php
}
add_action('login_head', 'balanz_login_styles');

/**
 * Change login logo URL to site home
 */
function balanz_login_logo_url() {
    return home_url('/');
}
add_filter('login_headerurl', 'balanz_login_logo_url');

/**
 * Change login logo title
 */
function balanz_login_logo_title() {
    return get_bloginfo('name');
}
add_filter('login_headertext', 'balanz_login_logo_title');

/**
 * Remove unnecessary dashboard meta boxes from page edit screen
 */
function balanz_remove_page_meta_boxes() {
    remove_meta_box('commentstatusdiv', 'page', 'normal');
    remove_meta_box('commentsdiv', 'page', 'normal');
    remove_meta_box('slugdiv', 'page', 'normal');
    remove_meta_box('authordiv', 'page', 'normal');
}
add_action('admin_menu', 'balanz_remove_page_meta_boxes');

/**
 * Disable comments globally (since we don't use them)
 */
function balanz_disable_comments() {
    // Close comments on front-end
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);
    
    // Hide existing comments
    add_filter('comments_array', '__return_empty_array', 10, 2);
    
    // Remove comments from admin bar
    add_action('admin_bar_menu', function($wp_admin_bar) {
        $wp_admin_bar->remove_node('comments');
    }, 999);
}
add_action('init', 'balanz_disable_comments');

/**
 * Disable RSS feeds (not needed for landing page)
 */
function balanz_disable_feeds() {
    add_action('do_feed', 'balanz_disable_feed_redirect', 1);
    add_action('do_feed_rdf', 'balanz_disable_feed_redirect', 1);
    add_action('do_feed_rss', 'balanz_disable_feed_redirect', 1);
    add_action('do_feed_rss2', 'balanz_disable_feed_redirect', 1);
    add_action('do_feed_atom', 'balanz_disable_feed_redirect', 1);
}
add_action('init', 'balanz_disable_feeds');

function balanz_disable_feed_redirect() {
    wp_redirect(home_url('/'));
    exit;
}