/**
 * Testimonials Slider Module
 * - 3D Carousel effect with perspective
 * - Auto-play every 6000ms
 * - Swipe left/right on mobile and desktop
 * - Click on avatar to navigate
 * - Starts in the middle by default
 */

export function initTestimonials() {
  const slider = document.getElementById("testimonialsSlider");
  if (!slider) return;

  const slidesContainer = slider.querySelector(".testimonials-slides");
  const slides = Array.from(slider.querySelectorAll(".testimonial-slide"));
  const navItems = Array.from(
    document.querySelectorAll(".testimonial-nav-item")
  );

  if (!slides.length) return;

  let currentSlide = Math.floor(slides.length / 2); // Start in middle
  let autoplayInterval = null;
  const INTERVAL_TIME = 6000;

  // Touch/Mouse handling for swipe
  let touchStartX = 0;
  let touchEndX = 0;
  let isDragging = false;

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

    // Touch events for mobile swipe
    slider.addEventListener("touchstart", handleTouchStart, { passive: true });
    slider.addEventListener("touchmove", handleTouchMove, { passive: false });
    slider.addEventListener("touchend", handleTouchEnd, { passive: true });

    // Mouse events for desktop drag
    slider.addEventListener("mousedown", handleMouseDown);
    slider.addEventListener("mousemove", handleMouseMove);
    slider.addEventListener("mouseup", handleMouseUp);
    slider.addEventListener("mouseleave", handleMouseUp);

    // Prevent default drag behavior
    slider.addEventListener("dragstart", (e) => e.preventDefault());

    // Keyboard navigation
    document.addEventListener("keydown", handleKeyboard);

    // Start autoplay
    startAutoplay();

    // Pause on hover
    slider.addEventListener("mouseenter", pauseAutoplay);
    slider.addEventListener("mouseleave", resumeAutoplay);
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

  // Touch handlers
  function handleTouchStart(e) {
    touchStartX = e.changedTouches[0].screenX;
    isDragging = true;
  }

  function handleTouchMove(e) {
    if (!isDragging) return;
    // Prevent default to stop page scrolling during swipe
    if (Math.abs(e.changedTouches[0].screenX - touchStartX) > 10) {
      e.preventDefault();
    }
  }

  function handleTouchEnd(e) {
    if (!isDragging) return;
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
    isDragging = false;
  }

  // Mouse handlers for desktop drag
  function handleMouseDown(e) {
    e.preventDefault(); // Prevent text selection
    touchStartX = e.clientX;
    isDragging = true;
    slider.style.cursor = "grabbing";
    document.body.style.userSelect = "none";
  }

  function handleMouseMove(e) {
    if (!isDragging) return;
    e.preventDefault(); // Prevent text selection during drag
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
      // Swiped left - next
      nextSlide();
      resetAutoplay();
    } else if (diff < -threshold) {
      // Swiped right - prev
      prevSlide();
      resetAutoplay();
    }
  }

  // Keyboard navigation
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

  // Autoplay
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
      goToSlide(currentSlide, false);
    }, 250);
  });

  // Set cursor style
  slider.style.cursor = "grab";

  init();
}
