<?php
/**
 * Philosophy Section
 * 
 * @package Balanz
 */

$title = get_field('philosophy_title') ?: 'Our Philosophy';
$video = get_field('philosophy_video');
$video_poster = get_field('philosophy_poster');
$quote = get_field('philosophy_quote') ?: "“We don't believe in extremes. Neither in endless diets nor in unchecked snacking. We believe in rhythm, balance, and ease...”";
$decorative_text = "balanced • No choice stress • just eat & go • stay balanced • No choice stress • just eat & go • stay balanced • No choice stress • just eat & go • stay balanced • No choice stress • just eat & go • stay ";
?>

<section class="philosophy-section">
    <div class="philosophy-container">
        <h2 class="philosophy-title animate-on-scroll"><?php echo esc_html($title); ?></h2>
        
        <div class="philosophy-video-wrapper animate-on-scroll">
            <!-- Video container with custom player -->
            <div class="philosophy-video" id="philosophyVideoContainer">
                <?php if ($video): ?>
                <video 
                    id="philosophyVideo"
                    poster="<?php echo $video_poster ? esc_url($video_poster['url']) : ''; ?>" 
                    preload="metadata"
                    playsinline
                >
                    <source src="<?php echo esc_url($video['url']); ?>" type="video/mp4">
                </video>
                <?php elseif ($video_poster): ?>
                <img src="<?php echo esc_url($video_poster['url']); ?>" alt="<?php echo esc_attr($title); ?>" class="video-poster">
                <?php else: ?>
                <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/about/our-philosophy/cover.jpg" alt="Our Philosophy" class="video-poster">
                <?php endif; ?>
                
                <!-- Custom play button -->
                <button class="play-button" id="playPhilosophyVideo" aria-label="Play video">
                  <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/about/our-philosophy/play-icon.svg" alt="Play">
                </button>
            </div>
        </div>
        
        <p class="philosophy-quote animate-on-scroll"><?php echo esc_html($quote); ?></p>
    </div>
    
    <!-- Single continuous wavy band - full width with SVG text on path -->
    <div class="philosophy-decorative-band">
        <svg class="philosophy-wave-svg" viewBox="0 0 3000 200" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <!-- Path for the ribbon shape (fill) -->
                <path id="waveFillPath" d="M0 100 C 250 20, 500 20, 750 100 C 1000 180, 1250 180, 1500 100 C 1750 20, 2000 20, 2250 100 C 2500 180, 2750 180, 3000 100 L 3000 130 C 2750 210, 2500 210, 2250 130 C 2000 50, 1750 50, 1500 130 C 1250 210, 1000 210, 750 130 C 500 50, 250 50, 0 130 Z"/>
                <!-- Path for text to follow (center line of the ribbon) -->
                <path id="waveTextPath" d="M-1500 115 C -1250 35, -1000 35, -750 115 C -500 195, -250 195, 0 115 C 250 35, 500 35, 750 115 C 1000 195, 1250 195, 1500 115 C 1750 35, 2000 35, 2250 115 C 2500 195, 2750 195, 3000 115 C 3250 35, 3500 35, 3750 115 C 4000 195, 4250 195, 4500 115" fill="none"/>
            </defs>
            
            <!-- The wavy ribbon fill -->
            <use href="#waveFillPath" fill="#2d4030"/>
            
            <!-- Text following the wave path - centered vertically on path -->
            <text class="wave-text" fill="#ffffff" dominant-baseline="middle" alignment-baseline="middle">
                <textPath href="#waveTextPath" startOffset="0%">
                    <animate attributeName="startOffset" from="0%" to="50%" dur="20s" repeatCount="indefinite"/>
                    <?php echo esc_html($decorative_text . $decorative_text); ?>
                </textPath>
            </text>
        </svg>
    </div>
</section>
