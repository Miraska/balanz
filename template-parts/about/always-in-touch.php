<?php
/**
 * Always In Touch Section - Contact Information
 * 
 * Desktop: Map left, content right
 * Mobile/Tablet: Content first, map below
 * 
 * @package Balanz
 */

$theme_uri = get_template_directory_uri();

// ACF Fields with defaults
$title = get_field('always_in_touch_title') ?: "We're always in touch";
$description = get_field('always_in_touch_description') ?: "From choosing your goal to enjoying fresh meals — Balanz takes care of the details so you don't have to.";

// Contact information
$whatsapp_url = get_field('contact_whatsapp', 'option') ?: '#';
$telegram_url = get_field('contact_telegram', 'option') ?: '#';
$phone = get_field('contact_phone', 'option') ?: '(303) 555-0105';
$email = get_field('contact_email', 'option') ?: 'felicia.reid@example.com';
$address = get_field('contact_address', 'option') ?: '2464 Royal Ln. Mesa, New Jersey 45463';
$hours = get_field('contact_hours', 'option') ?: '08:00 am - 06:00 pm';

// Map settings
$map_link = get_field('contact_map_link', 'option') ?: 'https://www.google.com/maps';
$map_image = get_field('contact_map_image', 'option');
$map_embed_url = get_field('contact_map_embed_url', 'option') ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.5826969851177!2d-74.35874368459452!3d40.74177957932788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzMwLjQiTiA3NMKwMjEnMjMuNCJX!5e0!3m2!1sen!2sus!4v1234567890';

// Icons
$icons = [
    'whatsapp' => $theme_uri . '/assets/images/about/always-in-touch/whats-app.svg',
    'telegram' => $theme_uri . '/assets/images/about/always-in-touch/tg.svg',
    'location' => $theme_uri . '/assets/images/about/always-in-touch/location.svg',
];
?>

<section class="always-in-touch-section" id="alwaysInTouch">
    <div class="always-in-touch-container">
        <div class="always-in-touch-grid">
            
            <!-- Map Column (First on Desktop, Last on Mobile) -->
            <div class="always-in-touch-map animate-on-scroll">
                <div class="map-wrapper">
                    <!-- Open in Google Maps button -->
                    <a href="<?php echo esc_url($map_link); ?>" 
                       class="map-open-btn" 
                       target="_blank" 
                       rel="noopener noreferrer">
                        <img src="<?php echo esc_url($icons['location']); ?>" alt="" class="map-btn-icon" aria-hidden="true">
                        <span>Open in Google Maps</span>
                    </a>
                    
                    <!-- Map iframe -->
                    <iframe 
                        src="<?php echo esc_url($map_embed_url); ?>"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Office Location Map">
                    </iframe>
                </div>
            </div>
            
            <!-- Content Column -->
            <div class="always-in-touch-content animate-on-scroll">
                <header class="always-in-touch-header">
                    <h2 class="always-in-touch-title"><?php echo esc_html($title); ?></h2>
                    <p class="always-in-touch-description"><?php echo esc_html($description); ?></p>
                </header>
                
                <div class="always-in-touch-details">
                    <!-- Contact Icons -->
                    <div class="contact-row">
                        <span class="contact-label">Contact:</span>
                        <div class="contact-icons">
                            <a href="<?php echo esc_url($whatsapp_url); ?>" 
                               class="contact-icon-btn" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               aria-label="Contact via WhatsApp">
                                <img src="<?php echo esc_url($icons['whatsapp']); ?>" alt="WhatsApp">
                            </a>
                            <a href="<?php echo esc_url($telegram_url); ?>" 
                               class="contact-icon-btn" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               aria-label="Contact via Telegram">
                                <img src="<?php echo esc_url($icons['telegram']); ?>" alt="Telegram">
                            </a>
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="contact-row">
                        <span class="contact-label">Phone number:</span>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="contact-value">
                            <?php echo esc_html($phone); ?>
                        </a>
                    </div>
                    
                    <!-- Email -->
                    <div class="contact-row">
                        <span class="contact-label">Email address:</span>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-value">
                            <?php echo esc_html($email); ?>
                        </a>
                    </div>
                    
                    <!-- Address -->
                    <div class="contact-row">
                        <span class="contact-label">Office/production address:</span>
                        <a href="<?php echo esc_url($map_link); ?>" 
                           class="contact-value" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <?php echo esc_html($address); ?>
                        </a>
                    </div>
                    
                    <!-- Hours -->
                    <div class="contact-row">
                        <span class="contact-label">Support service hours:</span>
                        <span class="contact-value contact-value--hours"><?php echo esc_html($hours); ?></span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
