<?php
/**
 * Assets - Enqueue Scripts & Styles
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Assets
 */
function balanz_enqueue_assets() {
    // Main CSS (Google Fonts loaded async via balanz_async_google_fonts)
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
        'nonceRefreshUrl' => admin_url('admin-ajax.php') . '?action=balanz_refresh_nonce',
        'themeUrl' => BALANZ_THEME_URI
    ]);
}
add_action('wp_enqueue_scripts', 'balanz_enqueue_assets');

/**
 * AJAX endpoint to refresh nonce for long sessions
 */
function balanz_refresh_nonce() {
    wp_send_json_success([
        'nonce' => wp_create_nonce('balanz_nonce')
    ]);
}
add_action('wp_ajax_balanz_refresh_nonce', 'balanz_refresh_nonce');
add_action('wp_ajax_nopriv_balanz_refresh_nonce', 'balanz_refresh_nonce');

/**
 * Preload critical assets for better performance
 * Priority 1 - loads before all other head content
 */
function balanz_preload_assets() {
    // DNS prefetch for Google Fonts (must be first)
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    
    // Preload main CSS
    echo '<link rel="preload" href="' . BALANZ_ASSETS_URI . '/css/main.css" as="style">' . "\n";
    
    // Preload logo for faster LCP
    echo '<link rel="preload" href="' . BALANZ_THEME_URI . '/assets/images/logo/logo.svg" as="image" type="image/svg+xml">' . "\n";
    
    // Preload hero background on home page for faster LCP
    if (is_front_page()) {
        echo '<link rel="preload" href="' . BALANZ_THEME_URI . '/assets/images/hero-bg.jpg" as="image">' . "\n";
    }
    
    // Preload About hero background
    if (is_page('about-us')) {
        echo '<link rel="preload" href="' . BALANZ_THEME_URI . '/assets/images/about/hero/bg.jpg" as="image">' . "\n";
    }
}
add_action('wp_head', 'balanz_preload_assets', 1);

/**
 * Load Google Fonts asynchronously (non-render-blocking)
 * Uses preload + media="print" trick for optimal performance
 */
function balanz_async_google_fonts() {
    $fonts_url = 'https://fonts.googleapis.com/css2?family=Asul:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap';
    ?>
    <link rel="preload" as="style" href="<?php echo esc_url($fonts_url); ?>">
    <link rel="stylesheet" href="<?php echo esc_url($fonts_url); ?>" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="<?php echo esc_url($fonts_url); ?>"></noscript>
    <?php
}
add_action('wp_head', 'balanz_async_google_fonts', 2);

/**
 * Add async/defer to scripts for better loading
 */
function balanz_script_attributes($tag, $handle, $src) {
    // Scripts to defer
    $defer_scripts = ['balanz-main'];
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'balanz_script_attributes', 10, 3);
