<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <!-- Логотип -->
                <div class="logo">
                    <a href="<?php echo home_url('/'); ?>">
                        <?php 
                        $logo = get_field('site_logo', 'option');
                        if ($logo): ?>
                            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php bloginfo('name'); ?>">
                        <?php else: ?>
                            <span class="logo-text"><?php bloginfo('name'); ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Навигация -->
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li><a href="#features" class="nav-link">Возможности</a></li>
                        <li><a href="#download" class="nav-link">Скачать</a></li>
                        <li><a href="#contact" class="nav-link">Контакты</a></li>
                    </ul>
                </nav>

                <!-- Мобильное меню -->
                <button class="mobile-menu-toggle" aria-label="Открыть меню">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <main id="main" class="site-main">
