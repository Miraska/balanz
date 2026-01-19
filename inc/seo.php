<?php
/**
 * SEO - Meta Tags, Open Graph, Sitemap, Robots
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SEO Meta Tags and Open Graph
 * Priority: ACF fields > WordPress settings > hardcoded fallbacks
 */
function balanz_seo_meta_tags() {
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
 * Generate sitemap.xml automatically
 */
function balanz_generate_sitemap() {
    // Only regenerate when pages are saved
    $sitemap_path = ABSPATH . 'sitemap.xml';
    
    $pages = get_pages(['post_status' => 'publish']);
    $site_url = get_site_url();
    $lastmod = date('Y-m-d');
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    // Home page
    $xml .= "  <url>\n";
    $xml .= "    <loc>{$site_url}/</loc>\n";
    $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
    $xml .= "    <changefreq>weekly</changefreq>\n";
    $xml .= "    <priority>1.0</priority>\n";
    $xml .= "  </url>\n";
    
    // Other pages
    foreach ($pages as $page) {
        if ($page->post_name === 'home') continue; // Skip home, already added
        
        $permalink = get_permalink($page->ID);
        $modified = get_the_modified_date('Y-m-d', $page->ID);
        
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$permalink}</loc>\n";
        $xml .= "    <lastmod>{$modified}</lastmod>\n";
        $xml .= "    <changefreq>monthly</changefreq>\n";
        $xml .= "    <priority>0.8</priority>\n";
        $xml .= "  </url>\n";
    }
    
    $xml .= '</urlset>';
    
    file_put_contents($sitemap_path, $xml);
}
add_action('save_post_page', 'balanz_generate_sitemap');
add_action('after_switch_theme', 'balanz_generate_sitemap');

/**
 * Generate robots.txt with sitemap reference
 */
function balanz_custom_robots_txt($output, $public) {
    $site_url = get_site_url();
    
    $output = "User-agent: *\n";
    $output .= "Allow: /\n\n";
    
    // Disallow admin and sensitive areas
    $output .= "Disallow: /wp-admin/\n";
    $output .= "Disallow: /wp-includes/\n";
    $output .= "Disallow: /wp-content/plugins/\n";
    $output .= "Disallow: /wp-content/cache/\n";
    $output .= "Disallow: /wp-json/\n";
    $output .= "Disallow: /xmlrpc.php\n";
    $output .= "Disallow: /?s=\n";
    $output .= "Disallow: /search/\n\n";
    
    // Allow assets
    $output .= "Allow: /wp-content/uploads/\n";
    $output .= "Allow: /wp-content/themes/balanz/assets/\n\n";
    
    // Sitemap
    $output .= "Sitemap: {$site_url}/sitemap.xml\n";
    
    return $output;
}
add_filter('robots_txt', 'balanz_custom_robots_txt', 10, 2);

/**
 * Add JSON-LD Structured Data for better SEO
 */
function balanz_add_schema_markup() {
    $site_name = get_bloginfo('name') ?: 'Balanz';
    $site_description = get_bloginfo('description') ?: 'Smart food service designed for busy people';
    $site_url = home_url('/');
    
    // Get logo URL
    $logo_url = BALANZ_THEME_URI . '/assets/images/logo/logo.svg';
    if (function_exists('get_field')) {
        $acf_logo = get_field('site_logo', 'option');
        if ($acf_logo && isset($acf_logo['url'])) {
            $logo_url = $acf_logo['url'];
        }
    }
    
    // Base Organization schema (appears on all pages)
    $organization_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $site_name,
        'url' => $site_url,
        'logo' => $logo_url,
        'description' => $site_description,
    ];
    
    // Add social links if available
    if (function_exists('get_field')) {
        $social_links = [];
        
        $facebook = get_field('facebook_link', 'option');
        $instagram = get_field('instagram_link', 'option');
        $linkedin = get_field('linkedin_link', 'option');
        $twitter = get_field('twitter_link', 'option');
        
        if ($facebook) $social_links[] = $facebook;
        if ($instagram) $social_links[] = $instagram;
        if ($linkedin) $social_links[] = $linkedin;
        if ($twitter) $social_links[] = $twitter;
        
        if (!empty($social_links)) {
            $organization_schema['sameAs'] = $social_links;
        }
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($organization_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    
    // WebApplication schema for home page
    if (is_front_page()) {
        $app_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebApplication',
            'name' => $site_name,
            'description' => $site_description,
            'url' => $site_url,
            'applicationCategory' => 'HealthApplication',
            'operatingSystem' => 'iOS, Android',
            'offers' => [
                '@type' => 'Offer',
                'price' => '0',
                'priceCurrency' => 'USD',
            ],
        ];
        
        // Add app store links if available
        if (function_exists('get_field')) {
            $app_store = get_field('app_store_link', 'option');
            $google_play = get_field('google_play_link', 'option');
            
            if ($app_store || $google_play) {
                $app_schema['downloadUrl'] = [];
                if ($app_store) $app_schema['downloadUrl'][] = $app_store;
                if ($google_play) $app_schema['downloadUrl'][] = $google_play;
            }
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode($app_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    // WebPage schema for other pages
    if (is_page() && !is_front_page()) {
        $page_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => get_the_title(),
            'description' => get_the_excerpt() ?: $site_description,
            'url' => get_permalink(),
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => $site_name,
                'url' => $site_url,
            ],
        ];
        
        echo '<script type="application/ld+json">' . wp_json_encode($page_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    // BreadcrumbList schema
    if (!is_front_page()) {
        $breadcrumb_schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => $site_url,
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => get_the_title(),
                    'item' => get_permalink(),
                ],
            ],
        ];
        
        echo '<script type="application/ld+json">' . wp_json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'balanz_add_schema_markup', 99);
