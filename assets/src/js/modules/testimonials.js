/**
 * Testimonials Slider Module
 * - 3D Carousel effect with perspective
 * - Auto-play every 6000ms
 * - Swipe left/right on mobile and desktop for main slider
 * - Swipe left/right for avatar navigation
 * - Click on avatar to navigate
 * - Starts in the middle by default
 * - Avatar slider with circular navigation and independent swipe
 */

export function initTestimonials() {
  const slider = document.getElementById("testimonialsSlider");
  if (!slider) return;

  const slidesContainer = slider.querySelector(".testimonials-slides");
  const slides = Array.from(slider.querySelectorAll(".testimonial-slide"));
  const navItems = Array.from(
    document.querySelectorAll(".testimonial-nav-item")
  );
  const navTrack = document.querySelector(".testimonials-nav-track");
  const navWrapper = document.querySelector(".testimonials-nav");

  if (!slides.length) return;

  let currentSlide = Math.floor(slides.length / 2); // Start in middle
  let autoplayInterval = null;
  const INTERVAL_TIME = 6000;

  // Avatar slider state
  let avatarOffset = 0;
  let maxAvatarOffset = 0;
  let minAvatarOffset = 0;

  // Touch/Mouse handling for main slider swipe
  let touchStartX = 0;
  let touchEndX = 0;
  let isDragging = false;

  // Touch/Mouse handling for avatar slider swipe
  let avatarTouchStartX = 0;
  let avatarTouchEndX = 0;
  let isAvatarDragging = false;
  let avatarStartOffset = 0;

  // Initialize
  function init() {
    // Set initial position
    goToSlide(currentSlide, false);

    // Prevent text selection during drag
    slidesContainer.style.userSelect = "none";
    slidesContainer.style.webkitUserSelect = "none";
    slidesContainer.style.mozUserSelect = "none";
    slidesContainer.style.msUserSelect = "none";

    // Nav click handlers
    navItems.forEach((item, index) => {
      item.addEventListener("click", () => {
        goToSlide(index);
        resetAutoplay();
      });
    });

    // Touch events for main slider mobile swipe
    slider.addEventListener("touchstart", handleTouchStart, { passive: true });
    slider.addEventListener("touchmove", handleTouchMove, { passive: false });
    slider.addEventListener("touchend", handleTouchEnd, { passive: true });

    // Mouse events for main slider desktop drag
    slider.addEventListener("mousedown", handleMouseDown);
    slider.addEventListener("mousemove", handleMouseMove);
    slider.addEventListener("mouseup", handleMouseUp);
    slider.addEventListener("mouseleave", handleMouseUp);

    // Avatar slider swipe events
    if (navWrapper) {
      navWrapper.addEventListener("touchstart", handleAvatarTouchStart, {
        passive: true,
      });
      navWrapper.addEventListener("touchmove", handleAvatarTouchMove, {
        passive: false,
      });
      navWrapper.addEventListener("touchend", handleAvatarTouchEnd, {
        passive: true,
      });

      // Mouse events for avatar slider
      navWrapper.addEventListener("mousedown", handleAvatarMouseDown);
      navWrapper.addEventListener("mousemove", handleAvatarMouseMove);
      navWrapper.addEventListener("mouseup", handleAvatarMouseUp);
      navWrapper.addEventListener("mouseleave", handleAvatarMouseUp);

      navWrapper.style.cursor = "grab";
    }

    // Prevent default drag behavior
    slider.addEventListener("dragstart", (e) => e.preventDefault());
    if (navWrapper) {
      navWrapper.addEventListener("dragstart", (e) => e.preventDefault());
    }

    // Keyboard navigation
    document.addEventListener("keydown", handleKeyboard);

    // Start autoplay
    startAutoplay();

    // Pause on hover
    slider.addEventListener("mouseenter", pauseAutoplay);
    slider.addEventListener("mouseleave", resumeAutoplay);

    // Initial avatar slider calculation
    calculateAvatarLimits();
  }

  // Calculate avatar slider limits
  function calculateAvatarLimits() {
    if (!navTrack || !navWrapper) return;

    const wrapperWidth = navWrapper.offsetWidth;
    const trackWidth = navTrack.scrollWidth;

    maxAvatarOffset = 0;
    minAvatarOffset = Math.min(0, wrapperWidth - trackWidth);

    // Reset offset if it's out of bounds
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, avatarOffset));
  }

  // Go to specific slide
  function goToSlide(index, animate = true) {
    currentSlide = index;

    // Update slide states for 3D carousel
    updateSlideStates();

    // Update nav
    navItems.forEach((item, i) => {
      item.classList.toggle("is-active", i === index);
    });

    // Update avatar slider position to center active item
    centerActiveAvatar();
  }

  // Center the active avatar in view
  function centerActiveAvatar() {
    if (!navTrack || !navWrapper || navItems.length === 0) return;

    calculateAvatarLimits();

    const wrapperWidth = navWrapper.offsetWidth;
    const activeItem = navItems[currentSlide];
    
    if (!activeItem) return;

    // Get item position relative to track
    const itemLeft = activeItem.offsetLeft;
    const itemWidth = activeItem.offsetWidth;
    const itemCenter = itemLeft + itemWidth / 2;

    // Calculate offset to center the item
    const desiredOffset = wrapperWidth / 2 - itemCenter;

    // Clamp to limits
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, desiredOffset));

    // Apply transform
    navTrack.style.transform = `translateX(${avatarOffset}px)`;
  }

  // Update avatar slider position (manual swipe)
  function updateAvatarSliderPosition() {
    if (!navTrack) return;
    navTrack.style.transform = `translateX(${avatarOffset}px)`;
  }

  // Update slide states (active, prev, next, far-prev, far-next)
  function updateSlideStates() {
    slides.forEach((slide, index) => {
      // Remove all state classes
      slide.classList.remove(
        "is-active",
        "is-prev",
        "is-next",
        "is-far-prev",
        "is-far-next"
      );

      const diff = index - currentSlide;

      if (diff === 0) {
        slide.classList.add("is-active");
      } else if (
        diff === -1 ||
        (currentSlide === 0 && index === slides.length - 1)
      ) {
        slide.classList.add("is-prev");
      } else if (
        diff === 1 ||
        (currentSlide === slides.length - 1 && index === 0)
      ) {
        slide.classList.add("is-next");
      } else if (diff < -1) {
        slide.classList.add("is-far-prev");
      } else if (diff > 1) {
        slide.classList.add("is-far-next");
      }
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

  // ============================================
  // MAIN SLIDER TOUCH/MOUSE HANDLERS
  // ============================================

  function handleTouchStart(e) {
    // Ignore if touch started on avatar navigation
    if (e.target.closest(".testimonials-nav")) return;
    
    touchStartX = e.changedTouches[0].screenX;
    isDragging = true;
  }

  function handleTouchMove(e) {
    if (!isDragging) return;
    // Ignore if touch on avatar navigation
    if (e.target.closest(".testimonials-nav")) return;
    
    // Prevent default to stop page scrolling during swipe
    if (Math.abs(e.changedTouches[0].screenX - touchStartX) > 10) {
      e.preventDefault();
    }
  }

  function handleTouchEnd(e) {
    if (!isDragging) return;
    // Ignore if touch on avatar navigation
    if (e.target.closest(".testimonials-nav")) return;
    
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
    isDragging = false;
  }

  function handleMouseDown(e) {
    // Ignore if mouse started on avatar navigation
    if (e.target.closest(".testimonials-nav")) return;
    
    e.preventDefault();
    touchStartX = e.clientX;
    isDragging = true;
    slider.style.cursor = "grabbing";
    document.body.style.userSelect = "none";
  }

  function handleMouseMove(e) {
    if (!isDragging) return;
    e.preventDefault();
  }

  function handleMouseUp(e) {
    if (!isDragging) return;
    touchEndX = e.clientX;
    handleSwipe();
    isDragging = false;
    slider.style.cursor = "grab";
    document.body.style.userSelect = "";
  }

  function handleSwipe() {
    const diff = touchStartX - touchEndX;
    const threshold = 50;

    if (diff > threshold) {
      nextSlide();
      resetAutoplay();
    } else if (diff < -threshold) {
      prevSlide();
      resetAutoplay();
    }
  }

  // ============================================
  // AVATAR SLIDER TOUCH/MOUSE HANDLERS
  // ============================================

  function handleAvatarTouchStart(e) {
    calculateAvatarLimits();
    
    // Only handle if there's overflow
    if (minAvatarOffset >= 0) return;

    avatarTouchStartX = e.changedTouches[0].clientX;
    avatarStartOffset = avatarOffset;
    isAvatarDragging = true;

    // Add dragging class to disable CSS transitions
    if (navTrack) {
      navTrack.classList.add("is-dragging");
    }

    // Stop event propagation to prevent main slider from handling it
    e.stopPropagation();
  }

  function handleAvatarTouchMove(e) {
    if (!isAvatarDragging) return;

    const currentX = e.changedTouches[0].clientX;
    const diff = currentX - avatarTouchStartX;

    avatarOffset = avatarStartOffset + diff;
    
    // Add rubber band effect at edges
    if (avatarOffset > maxAvatarOffset) {
      avatarOffset = maxAvatarOffset + (avatarOffset - maxAvatarOffset) * 0.3;
    } else if (avatarOffset < minAvatarOffset) {
      avatarOffset = minAvatarOffset + (avatarOffset - minAvatarOffset) * 0.3;
    }

    updateAvatarSliderPosition();

    // Prevent default to stop page scrolling
    if (Math.abs(diff) > 10) {
      e.preventDefault();
      e.stopPropagation();
    }
  }

  function handleAvatarTouchEnd(e) {
    if (!isAvatarDragging) return;

    // Remove dragging class to re-enable CSS transitions
    if (navTrack) {
      navTrack.classList.remove("is-dragging");
    }

    // Snap back to limits if overscrolled
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, avatarOffset));
    updateAvatarSliderPosition();

    isAvatarDragging = false;
    e.stopPropagation();
  }

  function handleAvatarMouseDown(e) {
    calculateAvatarLimits();
    
    // Only handle if there's overflow
    if (minAvatarOffset >= 0) return;

    e.preventDefault();
    e.stopPropagation();

    avatarTouchStartX = e.clientX;
    avatarStartOffset = avatarOffset;
    isAvatarDragging = true;

    // Add dragging class to disable CSS transitions
    if (navTrack) {
      navTrack.classList.add("is-dragging");
    }

    navWrapper.style.cursor = "grabbing";
    document.body.style.userSelect = "none";
  }

  function handleAvatarMouseMove(e) {
    if (!isAvatarDragging) return;

    e.preventDefault();
    e.stopPropagation();

    const currentX = e.clientX;
    const diff = currentX - avatarTouchStartX;

    avatarOffset = avatarStartOffset + diff;
    
    // Add rubber band effect at edges
    if (avatarOffset > maxAvatarOffset) {
      avatarOffset = maxAvatarOffset + (avatarOffset - maxAvatarOffset) * 0.3;
    } else if (avatarOffset < minAvatarOffset) {
      avatarOffset = minAvatarOffset + (avatarOffset - minAvatarOffset) * 0.3;
    }

    updateAvatarSliderPosition();
  }

  function handleAvatarMouseUp(e) {
    if (!isAvatarDragging) return;

    e.stopPropagation();

    // Remove dragging class to re-enable CSS transitions
    if (navTrack) {
      navTrack.classList.remove("is-dragging");
    }

    // Snap back to limits if overscrolled
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, avatarOffset));
    updateAvatarSliderPosition();

    isAvatarDragging = false;
    navWrapper.style.cursor = "grab";
    document.body.style.userSelect = "";
  }

  // ============================================
  // KEYBOARD & AUTOPLAY
  // ============================================

  function handleKeyboard(e) {
    if (
      !slider.matches(":hover") &&
      document.activeElement.closest(".testimonials-section") === null
    ) {
      return;
    }

    if (e.key === "ArrowLeft") {
      prevSlide();
      resetAutoplay();
    } else if (e.key === "ArrowRight") {
      nextSlide();
      resetAutoplay();
    }
  }

  function startAutoplay() {
    if (autoplayInterval) return;
    autoplayInterval = setInterval(nextSlide, INTERVAL_TIME);
  }

  function pauseAutoplay() {
    if (autoplayInterval) {
      clearInterval(autoplayInterval);
      autoplayInterval = null;
    }
  }

  function resumeAutoplay() {
    startAutoplay();
  }

  function resetAutoplay() {
    pauseAutoplay();
    startAutoplay();
  }

  // Handle window resize
  let resizeTimeout;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      calculateAvatarLimits();
      centerActiveAvatar();
      goToSlide(currentSlide, false);
    }, 250);
  });

  // Set cursor style
  slider.style.cursor = "grab";

  init();
}
