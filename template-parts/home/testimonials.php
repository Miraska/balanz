<?php
/**
 * Testimonials Section - Real Talk From Our Clients
 * 
 * @package Balanz
 */

$title = get_field('testimonials_title') ?: 'Real talk from out clients';
$testimonials = get_field('testimonials'); // Repeater

// Default testimonials
$theme_uri = get_template_directory_uri();
$default_testimonials = [
    [
        'text' => 'The best out there for you to diet and so much more waiting!',
        'description' => 'With Balanz, I gained energy in a month without sacrificing taste. Now lunch is not a stress but a pleasure',
        'name' => 'Jolie Day',
        'role' => 'UI/UX Designer',
        'avatar' => $theme_uri . '/assets/images/testimonials/avatar-1.jpg',
        'image' => $theme_uri . '/assets/images/testimonials/testimonails.png',
    ],
    [
        'text' => 'Life-changing experience that transformed my daily routine',
        'description' => 'I never thought healthy eating could be this easy and delicious. The variety is amazing and everything tastes incredible!',
        'name' => 'Sarah Mitchell',
        'role' => 'Marketing Manager',
        'avatar' => $theme_uri . '/assets/images/testimonials/avatar-2.jpg',
        'image' => $theme_uri . '/assets/images/testimonials/testimonails.png',
    ],
    [
        'text' => 'Best decision I made for my health this year',
        'description' => 'The convenience and quality are unmatched. My energy levels have improved dramatically and I actually enjoy my meals now.',
        'name' => 'Michael Chen',
        'role' => 'Software Engineer',
        'avatar' => $theme_uri . '/assets/images/testimonials/avatar-3.jpg',
        'image' => $theme_uri . '/assets/images/testimonials/testimonails.png',
    ],
    [
        'text' => 'Incredible service that exceeded all expectations',
        'description' => 'From the first meal, I was hooked. The flavors are restaurant-quality and the portions are perfect. Highly recommend!',
        'name' => 'Emma Rodriguez',
        'role' => 'Fitness Coach',
        'avatar' => $theme_uri . '/assets/images/testimonials/avatar-4.jpg',
        'image' => $theme_uri . '/assets/images/testimonials/testimonails.png',
    ],
    [
        'text' => 'Finally found a service that actually delivers on promises',
        'description' => 'No more meal prep stress or boring lunches. Every dish is thoughtfully prepared and absolutely delicious.',
        'name' => 'David Park',
        'role' => 'Business Owner',
        'avatar' => $theme_uri . '/assets/images/testimonials/avatar-5.jpg',
        'image' => $theme_uri . '/assets/images/testimonials/testimonails.png',
    ],
];

// Use custom testimonials if available, otherwise use defaults
$testimonials_data = $testimonials ?: $default_testimonials;
?>

<section class="testimonials-section" id="testimonials">
    <div class="testimonials-container">
        
        <!-- Section Header -->
        <header class="testimonials-header animate-on-scroll">
            <h2 class="testimonials-title"><?php echo esc_html($title); ?></h2>
        </header>
        
        <!-- Avatar Navigation Slider -->
        <div class="testimonials-nav-wrapper">
            <div class="testimonials-nav">
                <div class="testimonials-nav-track">
                    <?php 
                    $middle_index = floor(count($testimonials_data) / 2);
                    foreach ($testimonials_data as $index => $testimonial):
                        $avatar_url = is_array($testimonial['avatar']) ? $testimonial['avatar']['url'] : $testimonial['avatar'];
                    ?>
                    <button class="testimonial-nav-item <?php echo $index === $middle_index ? 'is-active' : ''; ?>" 
                            data-nav="<?php echo $index; ?>"
                            aria-label="View testimonial <?php echo $index + 1; ?>">
                        <img src="<?php echo esc_url($avatar_url); ?>" 
                             alt="<?php echo esc_attr($testimonial['name']); ?>">
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Slider -->
        <div class="testimonials-slider" id="testimonialsSlider">
            <div class="testimonials-track">
                <div class="testimonials-slides">
                    <?php foreach ($testimonials_data as $index => $testimonial): 
                        $image_url = is_array($testimonial['image']) ? $testimonial['image']['url'] : $testimonial['image'];
                        $slide_avatar_url = is_array($testimonial['avatar']) ? $testimonial['avatar']['url'] : $testimonial['avatar'];
                    ?>
                    <div class="testimonial-slide" data-slide="<?php echo $index; ?>">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($testimonial['name']); ?>">
                            </div>
                            <div class="testimonial-content">
                                <div class="quote-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/quote-up.svg" alt="Quote" width="48px" height="48px">
                                </div>
                                <h3 class="testimonial-title"><?php echo esc_html($testimonial['text']); ?></h3>
                                <p class="testimonial-description"><?php echo esc_html($testimonial['description']); ?></p>
                                
                                <div class="testimonial-author">
                                    <img src="<?php echo esc_url($slide_avatar_url); ?>" 
                                         alt="<?php echo esc_attr($testimonial['name']); ?>" 
                                         class="author-avatar">
                                    <div class="author-info">
                                        <div class="author-name"><?php echo esc_html($testimonial['name']); ?></div>
                                        <div class="author-role"><?php echo esc_html($testimonial['role']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
    </div>
</section>
