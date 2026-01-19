<?php
/**
 * Image Optimization - Compression, WebP, Lazy Loading
 * 
 * @package Balanz
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Оптимизация JPEG качества при создании подразмеров
 * Динамическое качество в зависимости от размера
 */
add_filter('jpeg_quality', function($quality, $context = '') {
    // Для превью используем более высокое качество
    if ($context === 'edit_image') {
        return 90;
    }
    return 82; // 82% - оптимальный баланс размер/качество
}, 10, 2);

/**
 * WebP качество
 */
add_filter('wp_editor_set_quality', function($quality, $mime_type) {
    if ($mime_type === 'image/webp') {
        return 80; // WebP более эффективен, можно ниже
    }
    return $quality;
}, 10, 2);

/**
 * Оптимизация оригинального изображения при загрузке
 */
function balanz_optimize_uploaded_image($file) {
    // Только для изображений
    $mime_type = $file['type'];
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
    
    if (!in_array($mime_type, $allowed_types)) {
        return $file;
    }
    
    $file_path = $file['file'];
    
    // Проверяем размер файла - оптимизируем только большие файлы (> 500KB)
    $file_size = filesize($file_path);
    if ($file_size < 512000) { // 500KB
        return $file;
    }
    
    // Получаем информацию об изображении
    $image_info = getimagesize($file_path);
    if (!$image_info) {
        return $file;
    }
    
    $width = $image_info[0];
    $height = $image_info[1];
    
    // Максимальные размеры для загружаемых изображений
    $max_width = 2400;
    $max_height = 2400;
    
    // Если изображение меньше лимита и не слишком большое - не трогаем
    if ($width <= $max_width && $height <= $max_height && $file_size < 1048576) { // 1MB
        return $file;
    }
    
    // Создаем редактор изображений WordPress
    $editor = wp_get_image_editor($file_path);
    
    if (is_wp_error($editor)) {
        return $file;
    }
    
    // Если изображение больше максимальных размеров - уменьшаем
    if ($width > $max_width || $height > $max_height) {
        $editor->resize($max_width, $max_height, false);
    }
    
    // Устанавливаем качество
    $editor->set_quality(85);
    
    // Сохраняем оптимизированное изображение
    $saved = $editor->save($file_path);
    
    if (!is_wp_error($saved)) {
        // Обновляем размер файла
        $file['size'] = filesize($file_path);
        
        if (WP_DEBUG) {
            $new_size = filesize($file_path);
            $saved_percent = round((1 - $new_size / $file_size) * 100);
            error_log("Balanz Image Optimizer: Сжато {$file['name']} - сохранено {$saved_percent}% ({$file_size} -> {$new_size} байт)");
        }
    }
    
    return $file;
}
add_filter('wp_handle_upload', 'balanz_optimize_uploaded_image');

/**
 * Конвертация PNG в JPEG для фото (не для изображений с прозрачностью)
 * Это значительно уменьшает размер файлов
 */
function balanz_maybe_convert_png_to_jpeg($file) {
    // Только для PNG файлов
    if ($file['type'] !== 'image/png') {
        return $file;
    }
    
    $file_path = $file['file'];
    
    // Проверяем размер - конвертируем только большие PNG (> 300KB)
    $file_size = filesize($file_path);
    if ($file_size < 307200) { // 300KB
        return $file;
    }
    
    // Проверяем наличие прозрачности
    $image = imagecreatefrompng($file_path);
    if (!$image) {
        return $file;
    }
    
    // Проверяем альфа-канал
    $has_transparency = false;
    $width = imagesx($image);
    $height = imagesy($image);
    
    // Проверяем несколько случайных пикселей на прозрачность
    // (полная проверка слишком медленная)
    for ($i = 0; $i < 100; $i++) {
        $x = rand(0, $width - 1);
        $y = rand(0, $height - 1);
        $rgba = imagecolorat($image, $x, $y);
        $alpha = ($rgba >> 24) & 0x7F;
        if ($alpha > 0) {
            $has_transparency = true;
            break;
        }
    }
    
    // Если есть прозрачность - оставляем PNG
    if ($has_transparency) {
        imagedestroy($image);
        return $file;
    }
    
    // Конвертируем в JPEG
    $jpeg_path = preg_replace('/\.png$/i', '.jpg', $file_path);
    
    // Создаем белый фон
    $bg = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($bg, 255, 255, 255);
    imagefill($bg, 0, 0, $white);
    imagecopy($bg, $image, 0, 0, 0, 0, $width, $height);
    
    // Сохраняем как JPEG
    if (imagejpeg($bg, $jpeg_path, 85)) {
        // Удаляем оригинальный PNG
        unlink($file_path);
        
        // Обновляем информацию о файле
        $file['file'] = $jpeg_path;
        $file['type'] = 'image/jpeg';
        $file['size'] = filesize($jpeg_path);
        
        // Обновляем имя файла
        $file['name'] = preg_replace('/\.png$/i', '.jpg', $file['name']);
        
        if (WP_DEBUG) {
            $new_size = filesize($jpeg_path);
            $saved_percent = round((1 - $new_size / $file_size) * 100);
            error_log("Balanz Image Optimizer: PNG -> JPEG конвертация - сохранено {$saved_percent}%");
        }
    }
    
    imagedestroy($image);
    imagedestroy($bg);
    
    return $file;
}
add_filter('wp_handle_upload', 'balanz_maybe_convert_png_to_jpeg', 5); // Раньше основной оптимизации

/**
 * Добавить lazy loading для всех изображений
 */
function balanz_add_lazy_loading($content) {
    // Добавляем loading="lazy" к img тегам, если его нет
    $content = preg_replace(
        '/<img(?![^>]*loading=)([^>]*)>/i',
        '<img loading="lazy"$1>',
        $content
    );
    return $content;
}
add_filter('the_content', 'balanz_add_lazy_loading');
add_filter('post_thumbnail_html', 'balanz_add_lazy_loading');
add_filter('widget_text', 'balanz_add_lazy_loading');

/**
 * WebP Support - генерация WebP версий при загрузке
 * Требует GD с поддержкой WebP или Imagick
 */
function balanz_generate_webp_version($metadata, $attachment_id) {
    // Проверяем поддержку WebP
    if (!function_exists('imagewebp') && !class_exists('Imagick')) {
        return $metadata;
    }
    
    $upload_dir = wp_upload_dir();
    $file_path = trailingslashit($upload_dir['basedir']) . $metadata['file'];
    
    // Только для JPEG и PNG
    $mime = get_post_mime_type($attachment_id);
    if (!in_array($mime, ['image/jpeg', 'image/png'])) {
        return $metadata;
    }
    
    // Создаем WebP версию оригинала
    balanz_create_webp($file_path);
    
    // Создаем WebP версии для всех размеров
    if (!empty($metadata['sizes'])) {
        $base_dir = dirname($file_path);
        foreach ($metadata['sizes'] as $size => $size_data) {
            $size_path = trailingslashit($base_dir) . $size_data['file'];
            balanz_create_webp($size_path);
        }
    }
    
    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'balanz_generate_webp_version', 10, 2);

/**
 * Создание WebP версии изображения
 */
function balanz_create_webp($file_path) {
    if (!file_exists($file_path)) {
        return false;
    }
    
    $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);
    
    // Пропускаем если WebP уже существует
    if (file_exists($webp_path)) {
        return true;
    }
    
    $image_info = getimagesize($file_path);
    if (!$image_info) {
        return false;
    }
    
    $mime = $image_info['mime'];
    
    // Создаем изображение в зависимости от типа
    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($file_path);
            break;
        case 'image/png':
            $image = imagecreatefrompng($file_path);
            // Сохраняем прозрачность
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        default:
            return false;
    }
    
    if (!$image) {
        return false;
    }
    
    // Сохраняем как WebP (качество 85)
    $result = imagewebp($image, $webp_path, 85);
    imagedestroy($image);
    
    return $result;
}

/**
 * Удаление WebP версий при удалении изображения
 */
function balanz_delete_webp_versions($attachment_id) {
    $metadata = wp_get_attachment_metadata($attachment_id);
    if (!$metadata) {
        return;
    }
    
    $upload_dir = wp_upload_dir();
    $file_path = trailingslashit($upload_dir['basedir']) . $metadata['file'];
    
    // Удаляем WebP оригинала
    $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);
    if (file_exists($webp_path)) {
        unlink($webp_path);
    }
    
    // Удаляем WebP всех размеров
    if (!empty($metadata['sizes'])) {
        $base_dir = dirname($file_path);
        foreach ($metadata['sizes'] as $size => $size_data) {
            $size_webp = trailingslashit($base_dir) . preg_replace('/\.(jpe?g|png)$/i', '.webp', $size_data['file']);
            if (file_exists($size_webp)) {
                unlink($size_webp);
            }
        }
    }
}
add_action('delete_attachment', 'balanz_delete_webp_versions');

/**
 * Allow SVG uploads
 */
function balanz_allow_svg($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'balanz_allow_svg');

/**
 * Add fetchpriority="high" to LCP images
 * This tells browsers to prioritize above-the-fold images
 */
function balanz_add_fetchpriority($attr, $attachment, $size) {
    // Only for large images that might be LCP elements
    if (in_array($size, ['full', 'large', 'hero-image'])) {
        // Check if we're in the first section (above fold)
        // This is a simple heuristic - the first few images get high priority
        static $image_count = 0;
        $image_count++;
        
        if ($image_count <= 2) {
            $attr['fetchpriority'] = 'high';
            $attr['loading'] = 'eager'; // Don't lazy load above-fold images
        }
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'balanz_add_fetchpriority', 10, 3);
