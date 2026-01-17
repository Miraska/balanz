<?php
/**
 * Team Section - The People Behind Balanz
 * 
 * 3 fixed card positions with content swap on navigation
 * 
 * @package Balanz
 */

$title = get_field('team_title') ?: 'The People Behind Balanz';
$description = get_field('team_description') ?: 'A team of chefs, nutrition specialists, and operators working together every day to deliver balanced, thoughtful, and reliable meals.';
$members = get_field('team_members'); // Repeater

// Default team members
$theme_uri = get_template_directory_uri();
$default_members = [
    [
        'name' => 'Robert Fox',
        'role' => 'Head Chef',
        'avatar' => $theme_uri . '/assets/images/about/people-behind-balanz/avatar-1.jpg',
        'quote' => "Good food isn't enough — it should make you feel good every day.",
        'bio' => 'Every dish at Balanz is cooked as if it were for my own family. I always ask: will it feel light after eating, and will you want it again tomorrow?',
        'social' => [
            ['type' => 'whatsapp', 'url' => '#'],
            ['type' => 'telegram', 'url' => '#'],
            ['type' => 'linkedin', 'url' => '#'],
        ],
    ],
    [
        'name' => 'Elena Martinez',
        'role' => 'Nutrition Specialist',
        'avatar' => $theme_uri . '/assets/images/about/people-behind-balanz/avatar-2.jpg',
        'quote' => 'Balance is not about restriction — it\'s about nourishment.',
        'bio' => 'I believe that healthy eating should be enjoyable. My goal is to create meal plans that are both nutritious and delicious, making wellness accessible to everyone.',
        'social' => [
            ['type' => 'whatsapp', 'url' => '#'],
            ['type' => 'telegram', 'url' => '#'],
            ['type' => 'linkedin', 'url' => '#'],
        ],
    ],
    [
        'name' => 'David Chen',
        'role' => 'Operations Manager',
        'avatar' => $theme_uri . '/assets/images/about/people-behind-balanz/avatar-3.jpg',
        'quote' => 'Reliability is the foundation of trust.',
        'bio' => 'From kitchen to doorstep, I ensure every meal arrives fresh and on time. Our operations are designed around your schedule, not ours.',
        'social' => [
            ['type' => 'whatsapp', 'url' => '#'],
            ['type' => 'telegram', 'url' => '#'],
            ['type' => 'linkedin', 'url' => '#'],
        ],
    ],
    [
        'name' => 'Sarah Johnson',
        'role' => 'Menu Designer',
        'avatar' => $theme_uri . '/assets/images/about/people-behind-balanz/avatar-4.jpg',
        'quote' => 'Every meal tells a story of flavor and care.',
        'bio' => 'I craft menus that surprise and delight. Each week brings new combinations that keep healthy eating exciting and something to look forward to.',
        'social' => [
            ['type' => 'whatsapp', 'url' => '#'],
            ['type' => 'telegram', 'url' => '#'],
            ['type' => 'linkedin', 'url' => '#'],
        ],
    ],
    [
        'name' => 'Michael Park',
        'role' => 'Quality Assurance',
        'avatar' => $theme_uri . '/assets/images/about/people-behind-balanz/avatar-5.jpg',
        'quote' => 'Excellence is in the details.',
        'bio' => 'I taste every dish and check every ingredient. Nothing leaves our kitchen without meeting our highest standards of quality and freshness.',
        'social' => [
            ['type' => 'whatsapp', 'url' => '#'],
            ['type' => 'telegram', 'url' => '#'],
            ['type' => 'linkedin', 'url' => '#'],
        ],
    ],
];

// Use custom members if available, otherwise use defaults
$members_data = $members ?: $default_members;

// Social icon paths
$social_icons = [
    'whatsapp' => $theme_uri . '/assets/images/about/people-behind-balanz/icons/whats-app.svg',
    'telegram' => $theme_uri . '/assets/images/about/people-behind-balanz/icons/tg.svg',
    'linkedin' => $theme_uri . '/assets/images/about/people-behind-balanz/icons/linked-in.svg',
];

// Prepare members data for JS (normalize avatar URLs)
$members_for_js = array_map(function($member) use ($social_icons) {
    $avatar = is_array($member['avatar']) ? $member['avatar']['url'] : $member['avatar'];
    $social = [];
    if (!empty($member['social'])) {
        foreach ($member['social'] as $s) {
            if (!empty($social_icons[$s['type']])) {
                $social[] = [
                    'type' => $s['type'],
                    'url' => $s['url'],
                    'icon' => $social_icons[$s['type']]
                ];
            }
        }
    }
    return [
        'name' => $member['name'],
        'role' => $member['role'],
        'avatar' => $avatar,
        'quote' => $member['quote'],
        'bio' => $member['bio'],
        'social' => $social
    ];
}, $members_data);
?>

<section class="team-section" id="teamSection">
    <div class="team-container">
        
        <!-- Section Header -->
        <header class="team-header animate-on-scroll">
            <h2 class="team-title"><?php echo esc_html($title); ?></h2>
            <p class="team-description"><?php echo esc_html($description); ?></p>
        </header>
        
        <!-- Card Slider - 3 Fixed Position Cards -->
        <div class="team-slider" id="teamSlider" data-members="<?php echo esc_attr(json_encode($members_for_js, JSON_UNESCAPED_UNICODE)); ?>">
            <div class="team-cards">
                <!-- Position 2 (back) - only visible on desktop -->
                <div class="team-card team-card--back-2">
                    <div class="team-card-inner">
                        <div class="team-card-avatar">
                            <img src="" alt="" class="js-avatar">
                        </div>
                        <div class="team-card-content">
                            <div class="team-card-header">
                                <h3 class="team-card-name js-name"></h3>
                                <p class="team-card-role js-role"></p>
                                <div class="team-card-social js-social"></div>
                            </div>
                            <div class="team-card-quote">
                                <p class="quote-text js-quote"></p>
                                <p class="quote-bio js-bio"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Position 1 (middle back) -->
                <div class="team-card team-card--back-1">
                    <div class="team-card-inner">
                        <div class="team-card-avatar">
                            <img src="" alt="" class="js-avatar">
                        </div>
                        <div class="team-card-content">
                            <div class="team-card-header">
                                <h3 class="team-card-name js-name"></h3>
                                <p class="team-card-role js-role"></p>
                                <div class="team-card-social js-social"></div>
                            </div>
                            <div class="team-card-quote">
                                <p class="quote-text js-quote"></p>
                                <p class="quote-bio js-bio"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Position 0 (front active) -->
                <div class="team-card team-card--active">
                    <div class="team-card-inner">
                        <div class="team-card-avatar">
                            <img src="" alt="" class="js-avatar">
                        </div>
                        <div class="team-card-content">
                            <div class="team-card-header">
                                <h3 class="team-card-name js-name"></h3>
                                <p class="team-card-role js-role"></p>
                                <div class="team-card-social js-social"></div>
                            </div>
                            <div class="team-card-quote">
                                <p class="quote-text js-quote"></p>
                                <p class="quote-bio js-bio"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Avatar Navigation -->
        <div class="team-nav-wrapper">
            <div class="team-nav">
                <div class="team-nav-track">
                    <?php 
                    foreach ($members_data as $index => $member):
                        $avatar_url = is_array($member['avatar']) ? $member['avatar']['url'] : $member['avatar'];
                        $is_active = $index === 0 ? 'is-active' : '';
                    ?>
                    <button class="team-nav-item <?php echo $is_active; ?>" 
                            data-index="<?php echo $index; ?>"
                            aria-label="View <?php echo esc_attr($member['name']); ?>">
                        <img src="<?php echo esc_url($avatar_url); ?>" 
                             alt="<?php echo esc_attr($member['name']); ?>">
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
    </div>
</section>
