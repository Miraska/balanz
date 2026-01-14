<?php
/**
 * FAQ Section
 * 
 * @package Balanz
 */

$title = get_field('faq_title') ?: 'Frequently Asked Questions';
$description = get_field('faq_description');
$image = get_field('faq_image');
$faqs = get_field('faq_items'); // Repeater
?>

<section class="faq-section" id="faq">
    <div class="faq-container">
        <div class="faq-content">
            
            <!-- Header & Accordion -->
            <div class="faq-main">
                <header class="faq-header animate-on-scroll">
                    <h2 class="faq-title"><?php echo esc_html($title); ?></h2>
                    <?php if ($description): ?>
                    <p class="faq-description"><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </header>
                
                <div class="faq-accordion animate-on-scroll" id="faqAccordion">
                    <?php 
                    if ($faqs):
                        foreach ($faqs as $index => $faq):
                            $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-faq="<?php echo $index; ?>">
                            <span class="question-number"><?php echo $number; ?>.</span>
                            <span class="question-text"><?php echo esc_html($faq['question']); ?></span>
                            <span class="question-toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6,9 12,15 18,9"/>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-answer <?php echo $index === 0 ? 'is-open' : ''; ?>">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else:
                        $defaults = [
                            ['q' => 'Will it be tasteless?', 'a' => 'No, absolutely not. All our meals are delicious and satisfying.'],
                            ['q' => 'Can I change the program?', 'a' => 'Yes, you can change your program at any time.'],
                            ['q' => 'How do I start the subscription?', 'a' => 'Simply download our app and choose your preferred plan.'],
                            ['q' => 'What if I don\'t like the dish?', 'a' => 'Contact us and we\'ll make it right.'],
                        ];
                        foreach ($defaults as $index => $faq):
                            $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                    <div class="faq-item">
                        <button class="faq-question" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-faq="<?php echo $index; ?>">
                            <span class="question-number"><?php echo $number; ?>.</span>
                            <span class="question-text"><?php echo $faq['q']; ?></span>
                            <span class="question-toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6,9 12,15 18,9"/>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-answer <?php echo $index === 0 ? 'is-open' : ''; ?>">
                            <p><?php echo $faq['a']; ?></p>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            
            <!-- Image -->
            <?php if ($image): ?>
            <div class="faq-image animate-on-scroll">
                <img src="<?php echo esc_url($image['url']); ?>" alt="">
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
