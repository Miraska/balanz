/**
 * Main JavaScript
 * Balanz Theme
 */

// Import SCSS
import '../scss/main.scss';

// Import GSAP
import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Import modules
import { initAnimations } from './modules/animations';
import { initHeader } from './modules/header';
import { initMobileMenu } from './modules/mobile-menu';
import { initContactForm } from './modules/contact-form';
import { initSmoothScroll } from './modules/smooth-scroll';

/**
 * Initialize app
 */
function init() {
  console.log('🚀 Balanz Theme Loaded');
  
  // Initialize modules
  initHeader();
  initMobileMenu();
  initAnimations();
  initContactForm();
  initSmoothScroll();
}

// DOM Ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}

// Window Load
window.addEventListener('load', () => {
  console.log('✅ All resources loaded');
  
  // Refresh ScrollTrigger после загрузки всех ресурсов
  ScrollTrigger.refresh();
});

// Export for external use
window.BalanzTheme = {
  gsap,
  ScrollTrigger
};
