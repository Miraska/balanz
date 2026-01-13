<?php
/**
 * Features Section
 * 
 * @package Balanz
 */

$features_title = get_field('features_title');
$features_subtitle = get_field('features_subtitle');
$features_list = get_field('features_list'); // Repeater field
?>

<section id="features" class="features-section">
    <div class="container">
        <div class="features-header">
            <?php if ($features_title): ?>
                <h2 class="section-title animate-fade-up"><?php echo esc_html($features_title); ?></h2>
            <?php endif; ?>
            
            <?php if ($features_subtitle): ?>
                <p class="section-subtitle animate-fade-up"><?php echo esc_html($features_subtitle); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ($features_list): ?>
            <div class="features-grid">
                <?php foreach ($features_list as $index => $feature): ?>
                    <div class="feature-card animate-fade-up" data-delay="<?php echo $index * 100; ?>">
                        <?php if (!empty($feature['icon'])): ?>
                            <div class="feature-icon">
                                <img src="<?php echo esc_url($feature['icon']['url']); ?>" 
                                     alt="<?php echo esc_attr($feature['title']); ?>">
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($feature['title'])): ?>
                            <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                        <?php endif; ?>
                        
                        <?php if (!empty($feature['description'])): ?>
                            <p class="feature-description"><?php echo esc_html($feature['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
