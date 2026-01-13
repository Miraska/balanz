<?php
/**
 * Balanz Theme Functions
 * 
 * @package Balanz
 * @version 1.0.0
 */

// Запретить прямой доступ к файлу
if (!defined('ABSPATH')) {
    exit;
}

// Константы темы
define('BALANZ_VERSION', '1.0.0');
define('BALANZ_THEME_DIR', get_template_directory());
define('BALANZ_THEME_URI', get_template_directory_uri());
define('BALANZ_ASSETS_URI', BALANZ_THEME_URI . '/assets/dist');

/**
 * Настройка темы
 */
function balanz_theme_setup() {
    // Поддержка заголовка
    add_theme_support('title-tag');
    
    // Поддержка миниатюр
    add_theme_support('post-thumbnails');
    
    // HTML5 разметка
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // Отключить редактор Gutenberg для страниц (используем ACF)
    add_filter('use_block_editor_for_post', '__return_false');
}
add_action('after_setup_theme', 'balanz_theme_setup');

/**
 * Подключение стилей и скриптов
 */
function balanz_enqueue_assets() {
    // Основные стили
    wp_enqueue_style(
        'balanz-main',
        BALANZ_ASSETS_URI . '/css/main.css',
        array(),
        BALANZ_VERSION
    );
    
    // GSAP (CDN для оптимизации)
    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        array(),
        '3.12.5',
        true
    );
    
    // ScrollTrigger для GSAP
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.5',
        true
    );
    
    // Основной JS
    wp_enqueue_script(
        'balanz-main',
        BALANZ_ASSETS_URI . '/js/main.js',
        array('gsap', 'gsap-scrolltrigger'),
        BALANZ_VERSION,
        true
    );
    
    // Передача данных в JS
    wp_localize_script('balanz-main', 'balanzData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('balanz_nonce'),
        'themeUrl' => BALANZ_THEME_URI
    ));
}
add_action('wp_enqueue_scripts', 'balanz_enqueue_assets');

/**
 * Настройка сохранения полей ACF в JSON
 */
add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

/**
 * Настройка ACF Options Page для глобальных настроек
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Настройки темы',
        'menu_title' => 'Настройки темы',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-generic',
        'position' => 60,
        'redirect' => false
    ));
    
    // Подстраница для ссылок на приложение
    acf_add_options_sub_page(array(
        'page_title' => 'Ссылки на приложение',
        'menu_title' => 'Ссылки на приложение',
        'parent_slug' => 'theme-settings',
    ));
    
    // Подстраница для контактов
    acf_add_options_sub_page(array(
        'page_title' => 'Контакты',
        'menu_title' => 'Контакты',
        'parent_slug' => 'theme-settings',
    ));
}

/**
 * Обработка формы обратной связи через AJAX
 */
function balanz_contact_form_handler() {
    // Проверка nonce
    check_ajax_referer('balanz_nonce', 'nonce');
    
    // Получение данных формы
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    
    // Валидация
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(array(
            'message' => 'Заполните все поля'
        ));
    }
    
    if (!is_email($email)) {
        wp_send_json_error(array(
            'message' => 'Некорректный email'
        ));
    }
    
    // Email для отправки (из ACF)
    $to = get_field('contact_email', 'option') ?: get_option('admin_email');
    
    // Тема письма
    $subject = 'Новая заявка с сайта Balanz';
    
    // Тело письма
    $body = "
        Имя: {$name}\n
        Email: {$email}\n
        Сообщение:\n{$message}
    ";
    
    // Заголовки
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $email
    );
    
    // Отправка
    $sent = wp_mail($to, $subject, $body, $headers);
    
    if ($sent) {
        wp_send_json_success(array(
            'message' => 'Спасибо! Ваша заявка отправлена.'
        ));
    } else {
        wp_send_json_error(array(
            'message' => 'Ошибка отправки. Попробуйте позже.'
        ));
    }
}
add_action('wp_ajax_balanz_contact_form', 'balanz_contact_form_handler');
add_action('wp_ajax_nopriv_balanz_contact_form', 'balanz_contact_form_handler');

/**
 * Отключение ненужных функций WordPress
 */
// Отключить emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Отключить REST API для неавторизованных (опционально)
add_filter('rest_authentication_errors', function($result) {
    if (!is_user_logged_in()) {
        return new WP_Error(
            'rest_disabled',
            'REST API disabled for non-authenticated users',
            array('status' => 401)
        );
    }
    return $result;
});

// Убрать версию WP из header
remove_action('wp_head', 'wp_generator');

/**
 * Оптимизация
 */
// Отключить jQuery Migrate
function balanz_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'balanz_remove_jquery_migrate');

/**
 * Security: Отключить XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');
