<?php
/**
 * Front Page Template - Home
 * 
 * @package Balanz
 */

get_header();
?>

<!-- Hero Section: What is Balanz -->
<?php get_template_part('template-parts/home/hero'); ?>

<!-- How It Works Section -->
<?php get_template_part('template-parts/home/how-it-works'); ?>

<!-- Why This Matters Section -->
<?php get_template_part('template-parts/home/why-matters'); ?>

<!-- App Screens Section -->
<?php get_template_part('template-parts/home/app-screens'); ?>

<!-- What This Offers Section -->
<?php get_template_part('template-parts/home/offers'); ?>

<!-- Testimonials Section -->
<?php get_template_part('template-parts/home/testimonials'); ?>

<!-- CTA Section -->
<?php get_template_part('template-parts/home/cta'); ?>

<?php
get_footer();
