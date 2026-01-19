import "../scss/main.scss";

import { initHeader } from "./modules/header";
import { initMobileMenu } from "./modules/mobile-menu";
import { initScrollAnimations } from "./modules/scroll-animations";
import { initHeroMarquee } from "./modules/hero";
import { initHowItWorks } from "./modules/how-it-works";
import { initAppScreens } from "./modules/app-screens";
import { initTestimonials } from "./modules/testimonials";
import { initAccordion } from "./modules/accordion";
import { initShare } from "./modules/share";
import { initCTA } from "./modules/cta";
import { initPhilosophyVideo } from "./modules/philosophy-video";
import { initValuesInAction } from "./modules/values-in-action";
import { initTeam } from "./modules/team";
import { initFoodCards } from "./modules/food-cards";

const modules = [
  { name: "header", fn: initHeader },
  { name: "mobileMenu", fn: initMobileMenu },
  { name: "scrollAnimations", fn: initScrollAnimations },
  { name: "heroMarquee", fn: initHeroMarquee },
  { name: "howItWorks", fn: initHowItWorks },
  { name: "appScreens", fn: initAppScreens },
  { name: "testimonials", fn: initTestimonials },
  { name: "accordion", fn: initAccordion },
  { name: "share", fn: initShare },
  { name: "cta", fn: initCTA },
  { name: "philosophyVideo", fn: initPhilosophyVideo },
  { name: "valuesInAction", fn: initValuesInAction },
  { name: "team", fn: initTeam },
  { name: "foodCards", fn: initFoodCards },
];

function initModule({ name, fn }) {
  try {
    fn();
  } catch (error) {
    if (process.env.NODE_ENV !== "production") {
      console.error(`[Balanz] Module "${name}" failed to initialize:`, error);
    }
  }
}

function init() {
  modules.forEach(initModule);
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", init);
} else {
  init();
}

window.addEventListener("load", () => {
  window.dispatchEvent(new Event("scroll"));
});
