    </main><!-- #main -->

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-inner">
            
            <!-- Footer Top -->
            <div class="footer-top">
                
                <!-- Logo & Tagline -->
                <div class="footer-brand">
                    <div class="footer-logo">
                        <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/logo/logo.svg" alt="Balanz Logo">
                    </div>
                    <p class="footer-tagline">Smart food for busy people want to eat well</p>
                </div>
                
                <!-- Download App -->
                <div class="footer-download">
                    <p class="footer-download-title">Download App on:</p>
                    <div class="footer-store-buttons">
                        <a href="<?php echo esc_url(get_field('app_store_link', 'option') ?: '#'); ?>" class="store-button" target="_blank" rel="noopener">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/footer/app-store.png" alt="Download on the App Store">
                        </a>
                        <a href="<?php echo esc_url(get_field('google_play_link', 'option') ?: '#'); ?>" class="store-button" target="_blank" rel="noopener">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/footer/google-play.png" alt="Get it on Google Play">
                        </a>
                    </div>
                </div>
                
                <!-- Navigation & Social -->
                <div class="footer-right">
                    <!-- Footer Navigation -->
                    <nav class="footer-nav">
                        <ul class="footer-nav-list">
                            <li><a href="<?php echo home_url('/'); ?>" class="footer-nav-link">Home</a></li>
                            <li><a href="<?php echo home_url('/about-us/'); ?>" class="footer-nav-link">About Us</a></li>
                        </ul>
                    </nav>
                    
                    <!-- Social Links -->
                    <div class="footer-social">
                        <a href="<?php echo esc_url(get_field('facebook_link', 'option') ?: '#'); ?>" class="social-link" target="_blank" rel="noopener" aria-label="Facebook">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/footer/facebook.svg" alt="Facebook">
                        </a>
                        <a href="<?php echo esc_url(get_field('instagram_link', 'option') ?: '#'); ?>" class="social-link" target="_blank" rel="noopener" aria-label="Instagram">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/footer/instagram.svg" alt="Instagram">
                        </a>
                        <a href="<?php echo esc_url(get_field('linkedin_link', 'option') ?: '#'); ?>" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/footer/linkedin.svg" alt="LinkedIn">
                        </a>
                        <a href="<?php echo esc_url(get_field('twitter_link', 'option') ?: '#'); ?>" class="social-link" target="_blank" rel="noopener" aria-label="X (Twitter)">
                            <img src="<?php echo BALANZ_THEME_URI; ?>/assets/images/footer/x.svg" alt="X">
                        </a>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p class="footer-copyright">
                    &copy; <?php echo date('Y'); ?> Balanz. All rights reserved.
                </p>
            </div>
            
        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
