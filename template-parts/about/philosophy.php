<?php
/**
 * Philosophy Section
 * 
 * @package Balanz
 */

$title = get_field('philosophy_title') ?: 'Our Philosophy';
$video = get_field('philosophy_video');
$video_poster = get_field('philosophy_poster');
$quote = get_field('philosophy_quote');
?>

<section class="philosophy-section">
    <div class="philosophy-container">
        <h2 class="philosophy-title animate-on-scroll"><?php echo esc_html($title); ?></h2>
        
        <div class="philosophy-video animate-on-scroll">
            <?php if ($video): ?>
            <video poster="<?php echo $video_poster ? esc_url($video_poster['url']) : ''; ?>" preload="none">
                <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
            </video>
            <?php elseif ($video_poster): ?>
            <img src="<?php echo esc_url($video_poster['url']); ?>" alt="<?php echo esc_attr($title); ?>">
            <?php else: ?>
            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/philosophy-video.jpg" alt="Our Philosophy">
            <?php endif; ?>
            
            <button class="play-button" id="playPhilosophyVideo" aria-label="Play video">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <polygon points="5,3 19,12 5,21"/>
                </svg>
            </button>
        </div>
        
        <?php if ($quote): ?>
        <p class="philosophy-quote animate-on-scroll">"<?php echo esc_html($quote); ?>"</p>
        <?php endif; ?>
    </div>
</section>
