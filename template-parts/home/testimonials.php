<?php
/**
 * Testimonials Section - Real Talk From Our Clients
 * 
 * @package Balanz
 */

$title = get_field('testimonials_title') ?: 'Real talk from out clients';
$testimonials = get_field('testimonials'); // Repeater
?>

<section class="testimonials-section" id="testimonials">
    <div class="testimonials-container">
        
        <!-- Section Header -->
        <header class="testimonials-header animate-on-scroll">
            <h2 class="testimonials-title"><?php echo esc_html($title); ?></h2>
        </header>
        
        <!-- Slider -->
        <div class="testimonials-slider" id="testimonialsSlider">
            <div class="testimonials-track">
                <div class="testimonials-slides">
                    <?php 
                    if ($testimonials):
                        foreach ($testimonials as $index => $testimonial):
                    ?>
                    <div class="testimonial-slide" data-slide="<?php echo $index; ?>">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-text-wrapper">
                                    <span class="quote-icon">"</span>
                                    <p class="testimonial-text"><?php echo esc_html($testimonial['text']); ?></p>
                                    
                                    <div class="testimonial-author">
                                        <?php if ($testimonial['avatar']): ?>
                                        <div class="testimonial-avatar">
                                            <img src="<?php echo esc_url($testimonial['avatar']['url']); ?>" 
                                                 alt="<?php echo esc_attr($testimonial['name']); ?>">
                                        </div>
                                        <?php endif; ?>
                                        <div class="testimonial-info">
                                            <span class="author-name"><?php echo esc_html($testimonial['name']); ?></span>
                                            <span class="author-role"><?php echo esc_html($testimonial['role']); ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php if ($testimonial['image']): ?>
                                <div class="testimonial-image">
                                    <img src="<?php echo esc_url($testimonial['image']['url']); ?>" alt="">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else:
                        // Default testimonials
                        $defaults = [
                            [
                                'text' => 'I\'ve been out there for you to diet and so much more wanting! Without the pressure — it\'s balanced without sacrificing taste. Now lunch feels like a treat, not a chore.',
                                'name' => 'Ali + Ela',
                                'role' => 'Balanz users',
                            ],
                        ];
                        foreach ($defaults as $index => $testimonial):
                    ?>
                    <div class="testimonial-slide" data-slide="<?php echo $index; ?>">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <div class="testimonial-text-wrapper">
                                    <span class="quote-icon">"</span>
                                    <p class="testimonial-text"><?php echo $testimonial['text']; ?></p>
                                    
                                    <div class="testimonial-author">
                                        <div class="testimonial-avatar">
                                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/avatar-<?php echo $index + 1; ?>.jpg" alt="">
                                        </div>
                                        <div class="testimonial-info">
                                            <span class="author-name"><?php echo $testimonial['name']; ?></span>
                                            <span class="author-role"><?php echo $testimonial['role']; ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="testimonial-image">
                                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/testimonial-<?php echo $index + 1; ?>.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            
            <!-- Avatar Navigation -->
            <div class="testimonials-nav">
                <?php 
                if ($testimonials):
                    foreach ($testimonials as $index => $testimonial):
                        if ($testimonial['avatar']):
                ?>
                <button class="testimonial-nav-item <?php echo $index === 0 ? 'is-active' : ''; ?>" data-nav="<?php echo $index; ?>">
                    <img src="<?php echo esc_url($testimonial['avatar']['url']); ?>" alt="">
                </button>
                <?php 
                        endif;
                    endforeach;
                else:
                    for ($i = 0; $i < 3; $i++):
                ?>
                <button class="testimonial-nav-item <?php echo $i === 1 ? 'is-active' : ''; ?>" data-nav="<?php echo $i; ?>">
                    <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/avatar-<?php echo $i + 1; ?>.jpg" alt="">
                </button>
                <?php 
                    endfor;
                endif;
                ?>
            </div>
            
            <!-- Swipe hint for mobile -->
            <div class="testimonials-swipe-hint">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
                <span>Swipe to see more</span>
            </div>
        </div>
        
    </div>
</section>
