<?php
/**
 * Share with Balanz Section - Contact Form
 * 
 * @package Balanz
 */

$title = get_field('share_title') ?: 'Share with Balanz';
$description = get_field('share_description') ?: 'We listen carefully to understand your needs, habits, and preferences - so we can improve your daily experience.';
$success_title = get_field('share_success_title') ?: 'Thank you for reaching out!';
$success_message = get_field('share_success_message') ?: 'Message sent successfully. Thank you for trusting Balanz.';

// Form fields
$name_label = get_field('share_name_label') ?: 'Full name';
$name_placeholder = get_field('share_name_placeholder') ?: 'Enter your full name';
$contact_label = get_field('share_contact_label') ?: 'Phone / Email';
$contact_placeholder = get_field('share_contact_placeholder') ?: 'Enter your phone number or email';
$message_label = get_field('share_message_label') ?: 'Your message';
$message_placeholder = get_field('share_message_placeholder') ?: "Tell us what's important to you in your diet...";
$checkbox_text = get_field('share_checkbox_text') ?: 'Want to receive balance tips';
$button_text = get_field('share_button_text') ?: 'Send Message';

$bg_image = get_field('share_background');
$bg_url = $bg_image ? esc_url($bg_image['url']) : get_template_directory_uri() . '/assets/images/about/share-with-balanz/bg.jpg';
$icon_url = get_template_directory_uri() . '/assets/images/about/share-with-balanz/icons/chat.svg';
?>

<section class="swb-section" id="share-with-balanz">
    <!-- Background Image -->
    <div class="swb-bg">
        <img src="<?php echo $bg_url; ?>" alt="" loading="lazy">
    </div>
    
    <div class="swb-container">
        <!-- Header -->
        <header class="swb-header animate-on-scroll">
            <h2 class="swb-title"><?php echo esc_html($title); ?></h2>
            <p class="swb-description"><?php echo esc_html($description); ?></p>
        </header>
        
        <!-- Form Card -->
        <div class="swb-card animate-on-scroll">
            <!-- Contact Form -->
            <form class="swb-form" id="shareWithBalanzForm" novalidate>
                <!-- Full Name -->
                <div class="swb-form-group">
                    <label class="swb-label" for="swbName"><?php echo esc_html($name_label); ?></label>
                    <div class="swb-input-wrapper">
                        <input 
                            type="text" 
                            class="swb-input" 
                            id="swbName" 
                            name="name" 
                            placeholder="<?php echo esc_attr($name_placeholder); ?>"
                            required
                        >
                        <button type="button" class="swb-input-clear" aria-label="Clear input">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Phone / Email -->
                <div class="swb-form-group">
                    <label class="swb-label" for="swbContact"><?php echo esc_html($contact_label); ?></label>
                    <div class="swb-input-wrapper">
                        <input 
                            type="text" 
                            class="swb-input" 
                            id="swbContact" 
                            name="contact" 
                            placeholder="<?php echo esc_attr($contact_placeholder); ?>"
                            required
                        >
                        <button type="button" class="swb-input-clear" aria-label="Clear input">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4L4 12M4 4L12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Message -->
                <div class="swb-form-group">
                    <label class="swb-label" for="swbMessage"><?php echo esc_html($message_label); ?></label>
                    <textarea 
                        class="swb-textarea" 
                        id="swbMessage" 
                        name="message" 
                        placeholder="<?php echo esc_attr($message_placeholder); ?>"
                        rows="4"
                    ></textarea>
                </div>
                
                <!-- Checkbox -->
                <div class="swb-form-group swb-checkbox-group">
                    <label class="swb-checkbox">
                        <input type="checkbox" name="subscribe" checked>
                        <span class="swb-checkbox-box">
                            <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 5L4.5 8.5L11 1.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="swb-checkbox-text"><?php echo esc_html($checkbox_text); ?></span>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="swb-submit">
                    <span><?php echo esc_html($button_text); ?></span>
                    <span class="swb-submit-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/link.svg" alt="" width="24" height="24">
                    </span>
                </button>
            </form>
            
            <!-- Success State -->
            <div class="swb-success" id="swbSuccess">
                <div class="swb-success-icon">
                    <img src="<?php echo esc_url($icon_url); ?>" alt="" width="88" height="88">
                </div>
                <h3 class="swb-success-title"><?php echo esc_html($success_title); ?></h3>
                <p class="swb-success-message"><?php echo esc_html($success_message); ?></p>
            </div>
        </div>
    </div>
</section>
