/**
 * How It Works Module
 * - Auto-play steps every 6000ms
 * - Click to select step (resets timer)
 * - Image changes with step
 * - Pause on hover over steps or image
 */

export function initHowItWorks() {
  const stepsContainer = document.getElementById("hiwSteps");
  const imageContainer = document.getElementById("hiwImage");
  const section = document.getElementById("how-it-works");

  if (!stepsContainer || !imageContainer) return;

  const steps = stepsContainer.querySelectorAll(".hiw-step");
  const images = imageContainer.querySelectorAll("img");

  if (!steps.length) return;

  let currentStep = 0;
  let autoplayInterval = null;
  const INTERVAL_TIME = 6000; // 6 seconds

  // Initialize
  function init() {
    // Add click listeners to steps
    steps.forEach((step, index) => {
      step.addEventListener("click", () => {
        goToStep(index);
        resetAutoplay(); // Reset timer on manual click
      });
    });

    // Start autoplay
    startAutoplay();
  }

  // Go to specific step
  function goToStep(index) {
    // Update current step
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

  // Start autoplay
  function startAutoplay() {
    if (autoplayInterval) clearInterval(autoplayInterval);
    autoplayInterval = setInterval(nextStep, INTERVAL_TIME);
  }

  // Reset autoplay (on manual interaction)
  function resetAutoplay() {
    clearInterval(autoplayInterval);
    startAutoplay();
  }

  // Pause on hover over steps
  stepsContainer.addEventListener("mouseenter", () => {
    clearInterval(autoplayInterval);
    autoplayInterval = null;
  });

  stepsContainer.addEventListener("mouseleave", () => {
    startAutoplay();
  });

  // Pause on hover over image
  imageContainer.addEventListener("mouseenter", () => {
    clearInterval(autoplayInterval);
    autoplayInterval = null;
  });

  imageContainer.addEventListener("mouseleave", () => {
    startAutoplay();
  });

  init();
}
