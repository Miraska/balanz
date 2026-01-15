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
        
        <!-- Avatar Navigation -->
        <div class="testimonials-nav">
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
        
        <!-- Slider -->
        <div class="testimonials-slider" id="testimonialsSlider">
            <div class="testimonials-track">
                <div class="testimonials-slides">
                    <?php foreach ($testimonials_data as $index => $testimonial): 
                        $image_url = is_array($testimonial['image']) ? $testimonial['image']['url'] : $testimonial['image'];
                    ?>
                    <div class="testimonial-slide" data-slide="<?php echo $index; ?>">
                        <div class="testimonial-card">
                            <div class="testimonial-image">
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($testimonial['name']); ?>">
                            </div>
                            <div class="testimonial-content">
                                <div class="quote-icon">
                                    <svg width="48" height="38" viewBox="0 0 48 38" fill="none">
                                        <path d="M0 19.2C0 8.96 5.44 2.08 16.32 0L19.2 4.16C13.12 6.08 10.08 9.6 9.6 14.72H20.16V38H0V19.2ZM27.84 19.2C27.84 8.96 33.28 2.08 44.16 0L47.04 4.16C40.96 6.08 37.92 9.6 37.44 14.72H48V38H27.84V19.2Z" fill="currentColor"/>
                                    </svg>
                                </div>
                                <h3 class="testimonial-title"><?php echo esc_html($testimonial['text']); ?></h3>
                                <p class="testimonial-description"><?php echo esc_html($testimonial['description']); ?></p>
                                
                                <div class="testimonial-author">
                                    <img src="<?php echo esc_url($avatar_url); ?>" 
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
