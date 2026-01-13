<?php
/**
 * Главная страница (Landing Page)
 * 
 * @package Balanz
 */

get_header();
?>

<!-- Hero Section -->
<?php get_template_part('template-parts/sections/hero'); ?>

<!-- Features Section -->
<?php get_template_part('template-parts/sections/features'); ?>

<!-- Download Section -->
<?php get_template_part('template-parts/sections/download'); ?>

<!-- Contact Section -->
<?php get_template_part('template-parts/sections/contact'); ?>

<?php
get_footer();
