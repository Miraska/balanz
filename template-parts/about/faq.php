<?php
/**
 * FAQ Section - About Page
 * 
 * @package Balanz
 */

$title = get_field('faq_title') ?: 'Frequently Asked Questions';
$description = get_field('faq_description') ?: 'A team of chefs, nutrition specialists, and operators working together every day to deliver balanced, thoughtful, and reliable meals.';
$image = get_field('faq_image');
$faqs = get_field('faq_items'); // Repeater

// Default image fallback
$image_url = $image ? esc_url($image['url']) : get_template_directory_uri() . '/assets/images/about/fqa/bg.jpg';

// Default FAQs
$default_faqs = [
    ['q' => 'Will it be varied?', 'a' => 'Yes, the menu changes daily, featuring seasonal products'],
    ['q' => 'Can I change the program?', 'a' => 'Yes, you can switch between programs at any time through the app or by contacting our support team.'],
    ['q' => 'How do I cancel the subscription?', 'a' => 'You can cancel your subscription anytime through your account settings or by reaching out to our customer service.'],
    ['q' => "What if I don't like the dish?", 'a' => 'Let us know and we\'ll make sure to adjust your preferences for future deliveries.'],
];

$faq_items = $faqs ?: $default_faqs;
?>

<section class="faq-section" id="faq">
    <div class="faq-container">
        <div class="faq-layout">
            
            <!-- Left Column: Header & Accordion -->
            <div class="faq-main">
                <header class="faq-header animate-on-scroll">
                    <h2 class="faq-title"><?php echo esc_html($title); ?></h2>
                    <p class="faq-description"><?php echo esc_html($description); ?></p>
                </header>
                
                <div class="faq-accordion animate-on-scroll" id="faqAccordion">
                    <?php 
                    foreach ($faq_items as $index => $faq):
                        $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                        $question = isset($faq['question']) ? $faq['question'] : $faq['q'];
                        $answer = isset($faq['answer']) ? $faq['answer'] : $faq['a'];
                        $is_first = $index === 0;
                    ?>
                    <div class="faq-item <?php echo $is_first ? 'is-active' : ''; ?>">
                        <button class="faq-question" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" data-faq="<?php echo $index; ?>">
                            <span class="faq-number"><?php echo $number; ?>.</span>
                            <div class="faq-question-content">
                                <span class="faq-question-text"><?php echo esc_html($question); ?></span>
                                <div class="faq-answer">
                                    <p><?php echo esc_html($answer); ?></p>
                                </div>
                            </div>
                            <span class="faq-toggle">
                                <svg class="faq-icon-plus" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                <svg class="faq-icon-minus" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Right Column: Image -->
            <div class="faq-image animate-on-scroll">
                <img src="<?php echo $image_url; ?>" alt="Healthy meal preparation" loading="lazy">
            </div>
            
        </div>
    </div>
</section>
