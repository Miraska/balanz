<?php
/**
 * Values Section
 * 
 * @package Balanz
 */

$title = get_field('values_title') ?: 'Values in Action';
$description = get_field('values_description');
$image = get_field('values_image');
$values = get_field('values_list'); // Repeater
?>

<section class="values-section">
    <div class="values-container">
        <div class="values-content">
            
            <!-- Text & Accordion -->
            <div class="values-text animate-on-scroll">
                <h2 class="values-title"><?php echo esc_html($title); ?></h2>
                <?php if ($description): ?>
                <p class="values-description"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
                
                <div class="values-accordion" id="valuesAccordion">
                    <?php 
                    if ($values):
                        foreach ($values as $index => $value):
                            $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                    <div class="value-item">
                        <button class="value-header" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-value="<?php echo $index; ?>">
                            <span class="value-number"><?php echo $number; ?>.</span>
                            <span class="value-title"><?php echo esc_html($value['title']); ?></span>
                            <span class="value-toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6,9 12,15 18,9"/>
                                </svg>
                            </span>
                        </button>
                        <div class="value-content <?php echo $index === 0 ? 'is-open' : ''; ?>">
                            <p><?php echo esc_html($value['content']); ?></p>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    else:
                        $defaults = [
                            ['title' => 'Real wellness', 'content' => 'We promote real wellness, not restrictive or harmful diets.'],
                            ['title' => 'Sustainability', 'content' => 'Our approach is built on long-term sustainability.'],
                            ['title' => 'Quality First', 'content' => 'We use only fresh, quality ingredients.'],
                            ['title' => 'Scientific basis', 'content' => 'All our programs are based on science.'],
                            ['title' => 'No guilt trips', 'content' => 'We believe food should be enjoyed without guilt.'],
                            ['title' => 'Honest pricing', 'content' => 'Transparent and fair pricing for everyone.'],
                        ];
                        foreach ($defaults as $index => $value):
                            $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                    <div class="value-item">
                        <button class="value-header" aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>" data-value="<?php echo $index; ?>">
                            <span class="value-number"><?php echo $number; ?>.</span>
                            <span class="value-title"><?php echo $value['title']; ?></span>
                            <span class="value-toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6,9 12,15 18,9"/>
                                </svg>
                            </span>
                        </button>
                        <div class="value-content <?php echo $index === 0 ? 'is-open' : ''; ?>">
                            <p><?php echo $value['content']; ?></p>
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
            <div class="values-image animate-on-scroll">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>
