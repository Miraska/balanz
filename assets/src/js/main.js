/**
 * Balanz Theme - Main JavaScript
 */

// Import SCSS
import "../scss/main.scss";

// Import modules
import { initHeader } from "./modules/header";
import { initMobileMenu } from "./modules/mobile-menu";
import { initScrollAnimations } from "./modules/scroll-animations";
import { initHeroMarquee } from "./modules/hero";
import { initHowItWorks } from "./modules/how-it-works";
import { initAppScreens } from "./modules/app-screens";
import { initTestimonials } from "./modules/testimonials";
import { initAccordion } from "./modules/accordion";
import { initShare } from "./modules/share";

/**
 * Initialize app
 */
function init() {
  console.log("🥗 Balanz Theme Loaded");

  // Core modules
  initHeader();
  initMobileMenu();
  initScrollAnimations();

  // Page-specific modules
  initHeroMarquee();
  initHowItWorks();
  initAppScreens();
  initTestimonials();
  initAccordion();
  initShare();
}

// DOM Ready
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}

// Window Load
window.addEventListener("load", () => {
  console.log("✅ All resources loaded");

  // Trigger scroll animations check
  window.dispatchEvent(new Event("scroll"));
});
