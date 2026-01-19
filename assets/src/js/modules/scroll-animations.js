/**
 * Scroll Animations Module
 * - Fade in + slide up on scroll into view
 */

export function initScrollAnimations() {
  const elements = document.querySelectorAll(".animate-on-scroll, .animate-stagger");

  if (!elements.length) return;

  // Intersection Observer options
  const options = {
    root: null,
    rootMargin: "0px 0px -50px 0px",
    threshold: 0.1,
  };

  // Observer callback
  const callback = (entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible");
        observer.unobserve(entry.target); // Only animate once
      }
    });
  };

  // Create observer
  const observer = new IntersectionObserver(callback, options);

  // Observe elements
  elements.forEach((el) => {
    observer.observe(el);
  });
}
