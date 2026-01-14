<?php
/**
 * Template Name: About Us
 * 
 * About Us Page Template
 * 
 * @package Balanz
 */

get_header();
?>

<!-- About Hero Section -->
<?php get_template_part('template-parts/about/hero'); ?>

<!-- Philosophy Section -->
<?php get_template_part('template-parts/about/philosophy'); ?>

<!-- Values Section -->
<?php get_template_part('template-parts/about/values'); ?>

<!-- How We Work Section -->
<?php get_template_part('template-parts/about/how-we-work'); ?>

<!-- Team Section -->
<?php get_template_part('template-parts/about/team'); ?>

<!-- Contact Section -->
<?php get_template_part('template-parts/about/contact'); ?>

<!-- FAQ Section -->
<?php get_template_part('template-parts/about/faq'); ?>

<!-- Share Section -->
<?php get_template_part('template-parts/about/share'); ?>

<?php
get_footer();
