<?php
/**
 * Helper Functions
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

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
 * Вывод оптимизированного изображения с WebP, srcset и aspect-ratio
 * Предотвращает CLS (Cumulative Layout Shift)
 * 
 * @param mixed $image ACF image array or attachment ID
 * @param string $size WordPress image size
 * @param array $args Additional arguments
 * @return string HTML img tag
 */
function balanz_image($image, $size = 'large', $args = []) {
    // Default arguments
    $defaults = [
        'class' => '',
        'alt' => '',
        'loading' => 'lazy',
        'decoding' => 'async',
        'fetchpriority' => '', // 'high' for above-the-fold images
        'sizes' => '100vw',
        'style' => '',
    ];
    $args = wp_parse_args($args, $defaults);
    
    // Get attachment ID
    $attachment_id = 0;
    if (is_array($image) && isset($image['ID'])) {
        $attachment_id = $image['ID'];
        $args['alt'] = $args['alt'] ?: ($image['alt'] ?? '');
    } elseif (is_numeric($image)) {
        $attachment_id = $image;
    }
    
    if (!$attachment_id) {
        return '';
    }
    
    // Get image data
    $image_src = wp_get_attachment_image_src($attachment_id, $size);
    if (!$image_src) {
        return '';
    }
    
    $url = $image_src[0];
    $width = $image_src[1];
    $height = $image_src[2];
    
    // Calculate aspect ratio for CLS prevention
    $aspect_ratio = $height > 0 ? round($width / $height, 4) : 1;
    
    // Get srcset for responsive images
    $srcset = wp_get_attachment_image_srcset($attachment_id, $size);
    
    // Check for WebP version
    $webp_url = preg_replace('/\.(jpe?g|png)$/i', '.webp', $url);
    $webp_path = str_replace(
        wp_upload_dir()['baseurl'],
        wp_upload_dir()['basedir'],
        $webp_url
    );
    $has_webp = file_exists($webp_path);
    
    // Build style with aspect-ratio for CLS prevention
    $style = $args['style'];
    if (!$style) {
        $style = "aspect-ratio: {$aspect_ratio}; width: 100%; height: auto;";
    }
    
    // Build attributes
    $attrs = [
        'src' => esc_url($url),
        'width' => esc_attr($width),
        'height' => esc_attr($height),
        'alt' => esc_attr($args['alt'] ?: get_post_meta($attachment_id, '_wp_attachment_image_alt', true)),
        'loading' => esc_attr($args['loading']),
        'decoding' => esc_attr($args['decoding']),
        'style' => esc_attr($style),
    ];
    
    if ($args['class']) {
        $attrs['class'] = esc_attr($args['class']);
    }
    
    if ($srcset) {
        $attrs['srcset'] = esc_attr($srcset);
        $attrs['sizes'] = esc_attr($args['sizes']);
    }
    
    if ($args['fetchpriority']) {
        $attrs['fetchpriority'] = esc_attr($args['fetchpriority']);
    }
    
    // Build HTML
    if ($has_webp) {
        // Use picture element with WebP source
        $webp_srcset = preg_replace('/\.(jpe?g|png)/i', '.webp', $srcset ?: $url);
        
        $html = '<picture>';
        $html .= '<source type="image/webp" srcset="' . esc_attr($webp_srcset) . '"';
        if ($srcset) {
            $html .= ' sizes="' . esc_attr($args['sizes']) . '"';
        }
        $html .= '>';
        $html .= '<img';
        foreach ($attrs as $name => $value) {
            $html .= ' ' . $name . '="' . $value . '"';
        }
        $html .= '>';
        $html .= '</picture>';
    } else {
        // Regular img tag
        $html = '<img';
        foreach ($attrs as $name => $value) {
            $html .= ' ' . $name . '="' . $value . '"';
        }
        $html .= '>';
    }
    
    return $html;
}

/**
 * Вывод фонового изображения с WebP поддержкой
 * 
 * @param mixed $image ACF image array or attachment ID
 * @param string $size WordPress image size
 * @return string CSS background-image value
 */
function balanz_bg_image($image, $size = 'large') {
    $attachment_id = 0;
    if (is_array($image) && isset($image['ID'])) {
        $attachment_id = $image['ID'];
    } elseif (is_numeric($image)) {
        $attachment_id = $image;
    }
    
    if (!$attachment_id) {
        return '';
    }
    
    $image_src = wp_get_attachment_image_src($attachment_id, $size);
    if (!$image_src) {
        return '';
    }
    
    return esc_url($image_src[0]);
}

/**
 * Preload critical image (для above-the-fold изображений)
 * Вызывать в wp_head
 * 
 * @param mixed $image ACF image array or attachment ID
 * @param string $size WordPress image size
 */
function balanz_preload_image($image, $size = 'large') {
    $attachment_id = 0;
    if (is_array($image) && isset($image['ID'])) {
        $attachment_id = $image['ID'];
    } elseif (is_numeric($image)) {
        $attachment_id = $image;
    }
    
    if (!$attachment_id) {
        return;
    }
    
    $image_src = wp_get_attachment_image_src($attachment_id, $size);
    if (!$image_src) {
        return;
    }
    
    $url = $image_src[0];
    $srcset = wp_get_attachment_image_srcset($attachment_id, $size);
    
    echo '<link rel="preload" as="image" href="' . esc_url($url) . '"';
    if ($srcset) {
        echo ' imagesrcset="' . esc_attr($srcset) . '"';
    }
    echo ">\n";
}
