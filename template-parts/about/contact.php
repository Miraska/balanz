<?php
/**
 * Contact Section
 * 
 * @package Balanz
 */

$title = get_field('contact_title') ?: "We're always in touch";
$phone = get_field('contact_phone', 'option');
$email = get_field('contact_email', 'option');
$address = get_field('contact_address', 'option');
$hours = get_field('contact_hours', 'option');
$map_embed = get_field('contact_map_embed', 'option');
?>

<section class="contact-section" id="contact">
    <div class="contact-container">
        <div class="contact-grid">
            
            <!-- Contact Info -->
            <div class="contact-info animate-on-scroll">
                <h2 class="contact-title"><?php echo esc_html($title); ?></h2>
                
                <div class="contact-details">
                    <?php if ($phone): ?>
                    <div class="contact-item">
                        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                        </svg>
                        <div>
                            <span class="contact-label">Phone</span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="contact-value">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($email): ?>
                    <div class="contact-item">
                        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <div>
                            <span class="contact-label">Email us</span>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-value">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($address): ?>
                    <div class="contact-item">
                        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        <div>
                            <span class="contact-label">Head quarters</span>
                            <span class="contact-value"><?php echo esc_html($address); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($hours): ?>
                    <div class="contact-item">
                        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12,6 12,12 16,14"/>
                        </svg>
                        <div>
                            <span class="contact-label">Open office hours</span>
                            <span class="contact-value"><?php echo esc_html($hours); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Map -->
            <div class="contact-map animate-on-scroll">
                <?php if ($map_embed): ?>
                <?php echo $map_embed; ?>
                <?php else: ?>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.5826969851177!2d-74.35874368459452!3d40.74177957932788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzMwLjQiTiA3NMKwMjEnMjMuNCJX!5e0!3m2!1sen!2sus!4v1234567890"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</section>
