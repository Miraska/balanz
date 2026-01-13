/**
 * Animations Module
 * GSAP анимации для элементов страницы
 */

import gsap from 'gsap';
import ScrollTrigger from 'gsap/ScrollTrigger';

export function initAnimations() {
  // Fade Up animations
  const fadeUpElements = document.querySelectorAll('.animate-fade-up');
  
  fadeUpElements.forEach((element, index) => {
    const delay = element.dataset.delay ? parseInt(element.dataset.delay) / 1000 : 0;
    
    gsap.from(element, {
      scrollTrigger: {
        trigger: element,
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      y: 60,
      opacity: 0,
      duration: 0.8,
      delay: delay,
      ease: 'power3.out'
    });
  });
  
  // Fade Down animations
  const fadeDownElements = document.querySelectorAll('.animate-fade-down');
  
  fadeDownElements.forEach((element) => {
    gsap.from(element, {
      scrollTrigger: {
        trigger: element,
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      y: -60,
      opacity: 0,
      duration: 0.8,
      ease: 'power3.out'
    });
  });
  
  // Fade Left animations
  const fadeLeftElements = document.querySelectorAll('.animate-fade-left');
  
  fadeLeftElements.forEach((element) => {
    gsap.from(element, {
      scrollTrigger: {
        trigger: element,
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      x: -60,
      opacity: 0,
      duration: 0.8,
      ease: 'power3.out'
    });
  });
  
  // Fade Right animations
  const fadeRightElements = document.querySelectorAll('.animate-fade-right');
  
  fadeRightElements.forEach((element) => {
    gsap.from(element, {
      scrollTrigger: {
        trigger: element,
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      x: 60,
      opacity: 0,
      duration: 0.8,
      ease: 'power3.out'
    });
  });
  
  // Scale animations
  const scaleElements = document.querySelectorAll('.animate-scale');
  
  scaleElements.forEach((element) => {
    gsap.from(element, {
      scrollTrigger: {
        trigger: element,
        start: 'top 80%',
        toggleActions: 'play none none none'
      },
      scale: 0.8,
      opacity: 0,
      duration: 0.8,
      ease: 'back.out(1.7)'
    });
  });
  
  // Feature cards stagger animation
  const featureCards = document.querySelectorAll('.feature-card');
  
  if (featureCards.length > 0) {
    gsap.from(featureCards, {
      scrollTrigger: {
        trigger: '.features-grid',
        start: 'top 70%',
        toggleActions: 'play none none none'
      },
      y: 60,
      opacity: 0,
      duration: 0.6,
      stagger: 0.15,
      ease: 'power3.out'
    });
  }
  
  // Hero shapes animation
  const heroShapes = document.querySelectorAll('.hero-bg-shapes .shape');
  
  heroShapes.forEach((shape, index) => {
    gsap.to(shape, {
      y: `${(index + 1) * 20}`,
      rotation: `${(index + 1) * 5}`,
      duration: 3 + index,
      repeat: -1,
      yoyo: true,
      ease: 'power1.inOut'
    });
  });
  
  console.log('✨ Animations initialized');
}

/**
 * Animate element (programmatic)
 */
export function animateElement(element, options = {}) {
  const defaults = {
    y: 40,
    opacity: 0,
    duration: 0.8,
    ease: 'power3.out'
  };
  
  const config = { ...defaults, ...options };
  
  return gsap.from(element, config);
}

/**
 * Animate on scroll
 */
export function animateOnScroll(element, animation, options = {}) {
  const defaults = {
    trigger: element,
    start: 'top 80%',
    toggleActions: 'play none none none'
  };
  
  const scrollConfig = { ...defaults, ...options };
  
  return gsap.from(element, {
    scrollTrigger: scrollConfig,
    ...animation
  });
}
