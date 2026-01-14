/**
 * Testimonials Slider Module
 * - Auto-play every 6000ms
 * - Swipe left/right on mobile
 * - Click on avatar to navigate
 */

export function initTestimonials() {
  const slider = document.getElementById('testimonialsSlider');
  if (!slider) return;
  
  const slidesContainer = slider.querySelector('.testimonials-slides');
  const slides = slider.querySelectorAll('.testimonial-slide');
  const navItems = slider.querySelectorAll('.testimonial-nav-item');
  
  if (!slides.length) return;
  
  let currentSlide = Math.floor(slides.length / 2); // Start in middle
  let autoplayInterval = null;
  const INTERVAL_TIME = 6000;
  
  // Touch handling
  let touchStartX = 0;
  let touchEndX = 0;
  
  // Initialize
  function init() {
    // Set initial position
    goToSlide(currentSlide);
    
    // Nav click handlers
    navItems.forEach((item, index) => {
      item.addEventListener('click', () => {
        goToSlide(index);
        resetAutoplay();
      });
    });
    
    // Touch events for swipe
    slidesContainer.addEventListener('touchstart', handleTouchStart, { passive: true });
    slidesContainer.addEventListener('touchend', handleTouchEnd, { passive: true });
    
    // Start autoplay
    startAutoplay();
  }
  
  // Go to specific slide
  function goToSlide(index) {
    currentSlide = index;
    
    // Move slides
    const offset = -index * 100;
    slidesContainer.style.transform = `translateX(${offset}%)`;
    
    // Update nav
    navItems.forEach((item, i) => {
      item.classList.toggle('is-active', i === index);
    });
  }
  
  // Next slide
  function nextSlide() {
    const next = (currentSlide + 1) % slides.length;
    goToSlide(next);
  }
  
  // Previous slide
  function prevSlide() {
    const prev = (currentSlide - 1 + slides.length) % slides.length;
    goToSlide(prev);
  }
  
  // Touch handlers
  function handleTouchStart(e) {
    touchStartX = e.changedTouches[0].screenX;
  }
  
  function handleTouchEnd(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }
  
  function handleSwipe() {
    const diff = touchStartX - touchEndX;
    const threshold = 50;
    
    if (diff > threshold) {
      // Swiped left - next
      nextSlide();
      resetAutoplay();
    } else if (diff < -threshold) {
      // Swiped right - prev
      prevSlide();
      resetAutoplay();
    }
  }
  
  // Autoplay
  function startAutoplay() {
    autoplayInterval = setInterval(nextSlide, INTERVAL_TIME);
  }
  
  function resetAutoplay() {
    clearInterval(autoplayInterval);
    startAutoplay();
  }
  
  // Pause on hover
  slider.addEventListener('mouseenter', () => {
    clearInterval(autoplayInterval);
  });
  
  slider.addEventListener('mouseleave', () => {
    startAutoplay();
  });
  
  init();
}
