/**
 * App Screens Module
 * Interactive prototype-like functionality with clickable features
 * Users can click on feature annotations to explore different screens
 */

export function initAppScreens() {
  const showcase = document.querySelector('.app-showcase');
  const phoneScreens = document.querySelectorAll('.phone-screen');
  const featureButtons = document.querySelectorAll('.app-feature-btn');
  const featureGroups = document.querySelectorAll('.feature-group');
  const prevBtn = document.querySelector('.app-nav-btn.prev-btn');
  const nextBtn = document.querySelector('.app-nav-btn.next-btn');
  
  if (!showcase || !phoneScreens.length) return;
  
  let currentScreen = 1;
  const totalScreens = 3;
  let imagesLoaded = false;
  
  // Preload all images to prevent jumping
  function preloadImages() {
    const images = Array.from(phoneScreens).map(screen => screen.querySelector('img'));
    const promises = images.map(img => {
      return new Promise((resolve) => {
        if (img.complete) {
          resolve();
        } else {
          img.addEventListener('load', resolve);
          img.addEventListener('error', resolve); // Resolve even on error
        }
      });
    });
    
    Promise.all(promises).then(() => {
      imagesLoaded = true;
      showcase.style.opacity = '1';
    });
  }
  
  // Set initial opacity to 0 while loading
  showcase.style.opacity = '0';
  showcase.style.transition = 'opacity 0.3s ease';
  preloadImages();
  
  /**
   * Switch to a specific screen with smooth transition
   */
  function switchScreen(screenNumber, animate = true) {
    if (screenNumber < 1 || screenNumber > totalScreens) return;
    if (screenNumber === currentScreen) return;
    
    currentScreen = screenNumber;
    
    // Update showcase data attribute
    showcase.setAttribute('data-active-screen', screenNumber);
    
    // Update phone screens
    phoneScreens.forEach(screen => {
      const screenNum = parseInt(screen.dataset.screen);
      if (screenNum === screenNumber) {
        screen.classList.add('active');
      } else {
        screen.classList.remove('active');
      }
    });
    
    // Update feature groups
    featureGroups.forEach(group => {
      const groupClass = group.classList.contains('screen-1-features') ? 1 :
                        group.classList.contains('screen-2-features') ? 2 : 3;
      
      if (groupClass === screenNumber) {
        group.classList.add('active');
      } else {
        group.classList.remove('active');
      }
    });
    
    // Update navigation buttons state
    updateNavigationButtons();
  }
  
  /**
   * Update prev/next button states
   */
  function updateNavigationButtons() {
    if (prevBtn) {
      prevBtn.disabled = currentScreen === 1;
    }
    if (nextBtn) {
      nextBtn.disabled = currentScreen === totalScreens;
    }
  }
  
  /**
   * Go to next screen
   */
  function nextScreen() {
    if (currentScreen < totalScreens) {
      switchScreen(currentScreen + 1);
    }
  }
  
  /**
   * Go to previous screen
   */
  function prevScreen() {
    if (currentScreen > 1) {
      switchScreen(currentScreen - 1);
    }
  }
  
  /**
   * Add ripple effect on button click
   */
  function createRipple(button, event) {
    const ripple = document.createElement('span');
    const rect = button.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height);
    const x = event.clientX - rect.left - size / 2;
    const y = event.clientY - rect.top - size / 2;
    
    ripple.style.cssText = `
      position: absolute;
      width: ${size}px;
      height: ${size}px;
      left: ${x}px;
      top: ${y}px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 50%;
      transform: scale(0);
      animation: ripple 0.6s ease-out;
      pointer-events: none;
    `;
    
    button.style.position = 'relative';
    button.style.overflow = 'hidden';
    button.appendChild(ripple);
    
    setTimeout(() => ripple.remove(), 600);
  }
  
  // Event Listeners
  
  // Feature button clicks
  featureButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      const screenNumber = parseInt(button.dataset.screen);
      
      // Create ripple effect
      if (button.classList.contains('single')) {
        createRipple(button, e);
      }
      
      // Add click feedback animation
      button.style.transform = 'scale(0.95)';
      setTimeout(() => {
        button.style.transform = '';
      }, 150);
      
      // Switch screen
      switchScreen(screenNumber);
      
      // Track interaction (for analytics)
      if (typeof gtag !== 'undefined') {
        gtag('event', 'app_screen_interaction', {
          'event_category': 'App Screens',
          'event_label': `Screen ${screenNumber}`,
          'feature': button.dataset.feature
        });
      }
    });
  });
  
  // Navigation buttons
  if (prevBtn) {
    prevBtn.addEventListener('click', (e) => {
      createRipple(prevBtn, e);
      prevScreen();
    });
  }
  
  if (nextBtn) {
    nextBtn.addEventListener('click', (e) => {
      createRipple(nextBtn, e);
      nextScreen();
    });
  }
  
  // Keyboard navigation
  let isInViewport = false;
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      isInViewport = entry.isIntersecting;
    });
  }, { threshold: 0.3 });
  
  observer.observe(showcase);
  
  document.addEventListener('keydown', (e) => {
    if (!isInViewport) return;
    
    if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
      e.preventDefault();
      prevScreen();
    } else if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
      e.preventDefault();
      nextScreen();
    } else if (e.key >= '1' && e.key <= '3') {
      e.preventDefault();
      switchScreen(parseInt(e.key));
    }
  });
  
  // Touch swipe support for mobile
  let touchStartX = 0;
  let touchStartY = 0;
  let touchEndX = 0;
  let touchEndY = 0;
  
  showcase.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
    touchStartY = e.changedTouches[0].screenY;
  }, { passive: true });
  
  showcase.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    touchEndY = e.changedTouches[0].screenY;
    handleSwipe();
  }, { passive: true });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    const diffX = touchStartX - touchEndX;
    const diffY = touchStartY - touchEndY;
    
    // Only trigger if horizontal swipe is dominant
    if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > swipeThreshold) {
      if (diffX > 0) {
        // Swipe left - next screen
        nextScreen();
      } else {
        // Swipe right - previous screen
        prevScreen();
      }
    }
  }
  
  // Add ripple animation CSS
  const style = document.createElement('style');
  style.textContent = `
    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }
  `;
  document.head.appendChild(style);
  
  // Initialize with screen 1
  switchScreen(1, false);
  
  console.log('✨ App Screens module initialized - Interactive prototype ready!');
  console.log('📱 Total screens:', totalScreens);
  console.log('🎯 Features loaded:', featureButtons.length);
}
