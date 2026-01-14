/**
 * Hero Section - Marquee Effect for Program Cards
 */

export function initHeroMarquee() {
  const programsGrid = document.querySelector(".programs-grid");
  
  if (!programsGrid) return;

  // Function to duplicate cards for seamless marquee
  function duplicateCards() {
    // Duplicate for mobile & tablet view (until desktop breakpoint at 900px)
    if (window.innerWidth <= 900) {
      // Check if cards are already duplicated
      if (programsGrid.dataset.duplicated === "true") return;

      // Get only original cards (without clones)
      const cards = Array.from(programsGrid.querySelectorAll(".program-card"));
      
      // Duplicate cards twice for smooth infinite scroll
      cards.forEach((card) => {
        const clone1 = card.cloneNode(true);
        const clone2 = card.cloneNode(true);
        programsGrid.appendChild(clone1);
        programsGrid.appendChild(clone2);
      });

      programsGrid.dataset.duplicated = "true";
    } else {
      // Remove duplicated cards for desktop view
      if (programsGrid.dataset.duplicated === "true") {
        const cards = Array.from(programsGrid.children);
        const originalCount = cards.length / 3;
        
        // Remove cloned cards
        cards.slice(originalCount).forEach((card) => card.remove());
        
        programsGrid.dataset.duplicated = "false";
      }
    }
  }

  // Pause animation on hover for better UX
  function handleHover() {
    if (window.innerWidth <= 900) {
      programsGrid.addEventListener("mouseenter", () => {
        programsGrid.style.animationPlayState = "paused";
      });

      programsGrid.addEventListener("mouseleave", () => {
        programsGrid.style.animationPlayState = "running";
      });
    }
  }

  // Initialize with slight delay to ensure DOM is ready
  setTimeout(() => {
    duplicateCards();
    handleHover();
  }, 100);

  // Handle resize
  let resizeTimer;
  window.addEventListener("resize", () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
      duplicateCards();
      handleHover();
    }, 250);
  });
}
