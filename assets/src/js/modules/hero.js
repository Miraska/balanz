/**
 * Hero Section - Infinite Marquee Effect for Program Cards
 * Uses CSS transform with duplicated content for seamless infinite scroll
 */

export function initHeroMarquee() {
  const programsGrid = document.querySelector(".programs-grid");
  
  if (!programsGrid) return;

  const MOBILE_BREAKPOINT = 900;
  let isInitialized = false;

  /**
   * Create marquee wrapper structure for seamless infinite scroll
   * Structure: .programs-grid > .marquee-track > [original cards + cloned cards]
   */
  function setupMarquee() {
    if (window.innerWidth > MOBILE_BREAKPOINT) {
      cleanupMarquee();
      return;
    }

    if (isInitialized) return;

    // Get original cards
    const originalCards = Array.from(programsGrid.querySelectorAll(".program-card"));
    if (!originalCards.length) return;

    // Create marquee track wrapper
    const marqueeTrack = document.createElement("div");
    marqueeTrack.className = "marquee-track";

    // Move original cards to track
    originalCards.forEach(card => {
      marqueeTrack.appendChild(card);
    });

    // Clone all cards once for seamless loop
    originalCards.forEach(card => {
      const clone = card.cloneNode(true);
      clone.classList.add("is-clone");
      clone.setAttribute("aria-hidden", "true");
      marqueeTrack.appendChild(clone);
    });

    // Append track to grid
    programsGrid.appendChild(marqueeTrack);
    programsGrid.classList.add("marquee-active");

    isInitialized = true;
  }

  /**
   * Remove marquee structure and restore original layout for desktop
   */
  function cleanupMarquee() {
    if (!isInitialized) return;

    const marqueeTrack = programsGrid.querySelector(".marquee-track");
    if (!marqueeTrack) return;

    // Get only original cards (not clones)
    const originalCards = marqueeTrack.querySelectorAll(".program-card:not(.is-clone)");

    // Move originals back to grid
    originalCards.forEach(card => {
      programsGrid.appendChild(card);
    });

    // Remove track and clones
    marqueeTrack.remove();
    programsGrid.classList.remove("marquee-active");

    isInitialized = false;
  }

  /**
   * Handle hover pause/resume
   */
  function setupHoverPause() {
    programsGrid.addEventListener("mouseenter", () => {
      if (window.innerWidth <= MOBILE_BREAKPOINT) {
        const track = programsGrid.querySelector(".marquee-track");
        if (track) track.style.animationPlayState = "paused";
      }
    });

    programsGrid.addEventListener("mouseleave", () => {
      if (window.innerWidth <= MOBILE_BREAKPOINT) {
        const track = programsGrid.querySelector(".marquee-track");
        if (track) track.style.animationPlayState = "running";
      }
    });
  }

  // Initialize
  function init() {
    setupMarquee();
    setupHoverPause();
  }

  // Handle resize with debounce
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      if (window.innerWidth > MOBILE_BREAKPOINT) {
        cleanupMarquee();
      } else {
        setupMarquee();
      }
    }, 200);
  });

  // Init with slight delay for DOM readiness
  setTimeout(init, 50);
}
