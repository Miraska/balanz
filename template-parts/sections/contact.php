<?php
/**
 * Contact Section
 * 
 * @package Balanz
 */

$contact_title = get_field('contact_title');
$contact_subtitle = get_field('contact_subtitle');
?>

<section id="contact" class="contact-section">
    <div class="container">
        <div class="contact-content">
            <div class="contact-header">
                <?php if ($contact_title): ?>
                    <h2 class="section-title animate-fade-up"><?php echo esc_html($contact_title); ?></h2>
                <?php endif; ?>
                
                <?php if ($contact_subtitle): ?>
                    <p class="section-subtitle animate-fade-up"><?php echo esc_html($contact_subtitle); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="contact-form-wrapper animate-fade-up">
                <form id="contactForm" class="contact-form">
                    <div class="form-group">
                        <label for="name">Имя <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control" 
                            required
                            placeholder="Введите ваше имя">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            required
                            placeholder="example@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Сообщение <span class="required">*</span></label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-control" 
                            rows="5" 
                            required
                            placeholder="Ваш вопрос или сообщение"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-submit">
                            <span class="btn-text">Отправить</span>
                            <span class="btn-loader">
                                <svg class="spinner" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                                    <path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor" stroke-width="4" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    
                    <div class="form-message"></div>
                </form>
            </div>
        </div>
    </div>
</section>
