<?php
/**
 * Team Section
 * 
 * @package Balanz
 */

$title = get_field('team_title') ?: 'The People Behind Balanz';
$description = get_field('team_description');
$members = get_field('team_members'); // Repeater
?>

<section class="team-section">
    <div class="team-container">
        <header class="team-header animate-on-scroll">
            <h2 class="team-title"><?php echo esc_html($title); ?></h2>
            <?php if ($description): ?>
            <p class="team-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
        </header>
        
        <?php 
        if ($members):
            foreach ($members as $member):
        ?>
        <div class="team-card animate-on-scroll">
            <?php if ($member['photo']): ?>
            <div class="team-avatar">
                <img src="<?php echo esc_url($member['photo']['url']); ?>" 
                     alt="<?php echo esc_attr($member['name']); ?>">
            </div>
            <?php endif; ?>
            
            <h3 class="team-name"><?php echo esc_html($member['name']); ?></h3>
            <p class="team-role"><?php echo esc_html($member['role']); ?></p>
            
            <?php if ($member['bio']): ?>
            <p class="team-bio"><?php echo esc_html($member['bio']); ?></p>
            <?php endif; ?>
            
            <?php if ($member['social']): ?>
            <div class="team-social">
                <?php foreach ($member['social'] as $social): ?>
                <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener" class="social-link">
                    <img src="<?php echo esc_url($social['icon']['url']); ?>" alt="">
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php 
            endforeach;
        else:
        ?>
        <div class="team-card animate-on-scroll">
            <div class="team-avatar">
                <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/team-1.jpg" alt="Robert Fox">
            </div>
            <h3 class="team-name">Robert Fox</h3>
            <p class="team-role">Founder</p>
            <p class="team-bio">Good food isn't enough — it should make you feel good every day. Every dish at Balanz is created on this same theme and belief. I always ask: will it be light after eating, and will you want it again tomorrow?</p>
        </div>
        <?php endif; ?>
    </div>
</section>
