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

/**
 * Save form submission to file (for Local development)
 */
function balanz_save_submission_to_file($data) {
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
    
    // Prepare email
    $to = 'miraska.007@gmail.com';
    $subject = 'New message from Balanz website - ' . $name;
    
    // Build email body
    $email_body = "You have received a new message from the Balanz website.\n\n";
    $email_body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $email_body .= "👤 Name: " . $name . "\n\n";
    $email_body .= "📧 Contact: " . $contact . "\n\n";
    
    if (!empty($message)) {
        $email_body .= "💬 Message:\n" . $message . "\n\n";
    }
    
    $email_body .= "📬 Subscribe to tips: " . ($subscribe ? 'Yes' : 'No') . "\n\n";
    $email_body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    $email_body .= "Sent from: " . home_url() . "\n";
    $email_body .= "Date: " . date_i18n('F j, Y \a\t g:i a') . "\n";
    $email_body .= "IP: " . balanz_get_client_ip() . "\n";
    
    // Email headers
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Balanz Website <noreply@' . parse_url(home_url(), PHP_URL_HOST) . '>',
    ];
    
    // Add reply-to if contact is email
    if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $headers[] = 'Reply-To: ' . $name . ' <' . $contact . '>';
    }
    
    // Save to file for Local development (always works)
    $submission_data = [
        'name' => $name,
        'contact' => $contact,
        'message' => $message,
        'subscribe' => $subscribe
    ];
    $file_path = balanz_save_submission_to_file($submission_data);
    
    // Log submission data for debugging
    error_log('=== Balanz Contact Form Submission ===');
    error_log('Name: ' . $name);
    error_log('Contact: ' . $contact);
    error_log('Message: ' . $message);
    error_log('Subscribe: ' . ($subscribe ? 'Yes' : 'No'));
    error_log('Saved to: ' . $file_path);
    error_log('======================================');
    
    // Try to send email (works only if mail server is configured)
    $sent = wp_mail($to, $subject, $email_body, $headers);
    
    if ($sent) {
        // Email sent successfully
        error_log('✅ Email sent successfully to ' . $to);
        
        wp_send_json_success([
            'message' => 'Thank you! Your message has been sent successfully.'
        ]);
    } else {
        // Email failed but data is saved to file
        error_log('⚠️ wp_mail() failed - but form saved to file');
        error_log('File location: ' . $file_path);
        
        // Return success anyway since we have the data
        wp_send_json_success([
            'message' => 'Thank you! Your message has been received. (Saved to file - Local Dev)'
        ]);
    }
}
add_action('wp_ajax_balanz_share_form', 'balanz_handle_share_form');
add_action('wp_ajax_nopriv_balanz_share_form', 'balanz_handle_share_form');

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