/**
 * Values in Action Module
 * - Auto-play steps every 6000ms ONLY when section is visible
 * - Click to select step (resets timer)
 * - Image changes with step
 * - Pause on hover over steps or image
 * - Uses IntersectionObserver for visibility detection
 */

export function initValuesInAction() {
  const stepsContainer = document.getElementById("viaSteps");
  const imageContainer = document.getElementById("viaImage");
  const section = document.getElementById("values-in-action");

  if (!stepsContainer || !imageContainer || !section) return;

  const steps = stepsContainer.querySelectorAll(".via-step");
  const images = imageContainer.querySelectorAll("img");

  if (!steps.length) return;

  let currentStep = 0;
  let autoplayInterval = null;
  let isHovering = false;
  let isSectionVisible = false;
  const INTERVAL_TIME = 6000; // 6 seconds

  // Go to specific step
  function goToStep(index) {
    currentStep = index;

    // Update steps
    steps.forEach((step, i) => {
      step.classList.toggle("is-active", i === index);
    });

    // Update images
    images.forEach((img, i) => {
      img.classList.toggle("is-active", i === index);
      img.classList.toggle("is-hidden", i !== index);
    });
  }

  // Next step
  function nextStep() {
    const next = (currentStep + 1) % steps.length;
    goToStep(next);
  }

  // Start autoplay only if section is visible and not hovering
  function startAutoplay() {
    if (autoplayInterval) clearInterval(autoplayInterval);
    
    // Only autoplay when section is visible and user is not hovering
    if (isSectionVisible && !isHovering) {
      autoplayInterval = setInterval(nextStep, INTERVAL_TIME);
    }
  }

  // Stop autoplay
  function stopAutoplay() {
    if (autoplayInterval) {
      clearInterval(autoplayInterval);
      autoplayInterval = null;
    }
  }

  // Reset autoplay (on manual interaction)
  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }

  // Setup IntersectionObserver to detect when section is visible
  function setupVisibilityObserver() {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          isSectionVisible = entry.isIntersecting;
          
          if (isSectionVisible) {
            // Section came into view - start autoplay
            startAutoplay();
          } else {
            // Section left view - stop autoplay to prevent layout jumps
            stopAutoplay();
          }
        });
      },
      {
        // Trigger when at least 30% of section is visible
        threshold: 0.3,
        // Add some margin to trigger slightly before fully in view
        rootMargin: "0px"
      }
    );

    observer.observe(section);
  }

  // Initialize
  function init() {
    // Add click listeners to steps
    steps.forEach((step, index) => {
      step.addEventListener("click", () => {
        goToStep(index);
        resetAutoplay();
      });
    });

    // Pause on hover over steps
    stepsContainer.addEventListener("mouseenter", () => {
      isHovering = true;
      stopAutoplay();
    });

    stepsContainer.addEventListener("mouseleave", () => {
      isHovering = false;
      startAutoplay();
    });

    // Pause on hover over image (desktop)
    imageContainer.addEventListener("mouseenter", () => {
      isHovering = true;
      stopAutoplay();
    });

    imageContainer.addEventListener("mouseleave", () => {
      isHovering = false;
      startAutoplay();
    });

    // Setup visibility observer - autoplay only when section is in viewport
    setupVisibilityObserver();
  }

  init();
}
