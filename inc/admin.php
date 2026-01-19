<?php
/**
 * Admin Customizations - Dashboard, Menus, Branding
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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

/**
 * Limit post revisions to save database space
 */
if (!defined('WP_POST_REVISIONS')) {
    define('WP_POST_REVISIONS', 3);
}

/**
 * Remove admin bar for non-admins on frontend
 */
function balanz_remove_admin_bar_for_editors() {
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'balanz_remove_admin_bar_for_editors');
