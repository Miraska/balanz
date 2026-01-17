<?php
/**
 * Theme Footer
 * 
 * @package Balanz
 */

// Get editable content from ACF options
$site_name = get_bloginfo('name');
$footer_tagline = get_field('footer_tagline', 'option') ?: 'Smart food for busy people who want to eat well';
$footer_download_title = get_field('footer_download_title', 'option') ?: 'Download App on:';
$copyright_text = get_field('footer_copyright', 'option') ?: '© ' . date('Y') . ' ' . $site_name . '. All rights reserved.';

// Navigation texts (reuse from header or separate)
$nav_home_text = get_field('nav_home_text', 'option') ?: 'Home';
$nav_about_text = get_field('nav_about_text', 'option') ?: 'About Us';

// Logo from ACF or default
$footer_logo = get_field('footer_logo', 'option');
$footer_logo_url = $footer_logo ? esc_url($footer_logo['url']) : BALANZ_THEME_URI . '/assets/images/logo/logo.svg';

// Social links
$facebook_link = get_field('facebook_link', 'option');
$instagram_link = get_field('instagram_link', 'option');
$linkedin_link = get_field('linkedin_link', 'option');
$twitter_link = get_field('twitter_link', 'option');

// App store links
$app_store_link = get_field('app_store_link', 'option');
$google_play_link = get_field('google_play_link', 'option');
?>
    </main><!-- #main -->

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner">
            
            <!-- Footer Top -->
            <div class="footer-top">
                
                <!-- Logo & Tagline -->
                <div class="footer-brand">
                    <div class="footer-logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($site_name); ?> - Home">
                            <img src="<?php echo $footer_logo_url; ?>" alt="<?php echo esc_attr($site_name); ?> Logo">
                        </a>
                    </div>
                    <p class="footer-tagline"><?php echo esc_html($footer_tagline); ?></p>
                </div>
                
                <!-- Download App -->
                <div class="footer-download">
                    <p class="footer-download-title"><?php echo esc_html($footer_download_title); ?></p>
                    <div class="footer-store-buttons">
                        <a href="<?php echo esc_url($app_store_link ?: '#'); ?>" class="store-button" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/footer/app-store.png'); ?>" alt="Download on the App Store">
                        </a>
                        <a href="<?php echo esc_url($google_play_link ?: '#'); ?>" class="store-button" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/footer/google-play.png'); ?>" alt="Get it on Google Play">
                        </a>
                    </div>
                </div>
                
                <!-- Navigation & Social -->
                <div class="footer-right">
                    <!-- Footer Navigation -->
                    <nav class="footer-nav" aria-label="Footer navigation">
                        <ul class="footer-nav-list">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="footer-nav-link"><?php echo esc_html($nav_home_text); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/about-us/')); ?>" class="footer-nav-link"><?php echo esc_html($nav_about_text); ?></a></li>
                        </ul>
                    </nav>
                    
                    <!-- Social Links -->
                    <div class="footer-social">
                        <a href="<?php echo esc_url($facebook_link ?: '#'); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/footer/facebook.svg'); ?>" alt="" aria-hidden="true">
                        </a>
                        <a href="<?php echo esc_url($instagram_link ?: '#'); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/footer/instagram.svg'); ?>" alt="" aria-hidden="true">
                        </a>
                        <a href="<?php echo esc_url($linkedin_link ?: '#'); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/footer/linkedin.svg'); ?>" alt="" aria-hidden="true">
                        </a>
                        <a href="<?php echo esc_url($twitter_link ?: '#'); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
                            <img src="<?php echo esc_url(BALANZ_THEME_URI . '/assets/images/footer/x.svg'); ?>" alt="" aria-hidden="true">
                        </a>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="footer-copyright">
                    <?php echo wp_kses_post($copyright_text); ?>
                </p>
            </div>
            
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
