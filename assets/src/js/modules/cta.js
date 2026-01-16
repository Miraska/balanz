/**
 * CTA Section Animations
 */

export function initCTA() {
  const ctaSection = document.querySelector(".cta-section");
  if (!ctaSection) return;

  const phones = ctaSection.querySelectorAll(".cta-phone");
  let hasAnimated = false;

  // Intersection Observer for scroll animation
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !hasAnimated) {
          animatePhones();
          hasAnimated = true;
        }
      });
    },
    {
      threshold: 0.3, // Trigger when 30% of section is visible
      rootMargin: "0px 0px -100px 0px", // Start animation slightly before center
    }
  );

  observer.observe(ctaSection);

  function animatePhones() {
    phones.forEach((phone, index) => {
      const phoneType = phone.getAttribute("data-phone");
      let delay = 0;

      // Stagger animation delays
      if (phoneType === "left") {
        delay = 100;
      } else if (phoneType === "right") {
        delay = 200;
      } else if (phoneType === "center") {
        delay = 400;
      } else if (phoneType === "center-right") {
        delay = 300;
      }

      setTimeout(() => {
        phone.classList.add("animate-in");
      }, delay);
    });
  }

  // Add parallax effect on scroll (optional enhancement)
  let ticking = false;

  function updatePhonePositions() {
    const rect = ctaSection.getBoundingClientRect();
    const scrollPercent = 1 - rect.top / window.innerHeight;

    if (scrollPercent > 0 && scrollPercent < 1) {
      phones.forEach((phone) => {
        const phoneType = phone.getAttribute("data-phone");
        let translateX = 0;
        let translateY = 0;

        if (phoneType === "left") {
          translateX = scrollPercent * 20 - 20; // Slight parallax
        } else if (phoneType === "right") {
          translateX = -(scrollPercent * 20 - 20);
        } else if (phoneType === "center") {
          translateY = scrollPercent * 15 - 15;
        } else if (phoneType === "center-right") {
          translateX = -(scrollPercent * 15 - 15);
          translateY = scrollPercent * 10 - 10;
        }

        if (phone.classList.contains("animate-in")) {
          if (phoneType === "center") {
            phone.style.transform = `translateY(${translateY}px) rotate(-10deg)`;
          } else if (phoneType === "center-right") {
            phone.style.transform = `translate(${translateX}px, calc(-50% + ${translateY}px))`;
          } else {
            const baseTransform = "translate(0, -50%)";
            phone.style.transform = `translate(${translateX}px, -50%)`;
          }
        }
      });
    }

    ticking = false;
  }

  window.addEventListener("scroll", () => {
    if (!ticking && hasAnimated) {
      window.requestAnimationFrame(updatePhonePositions);
      ticking = true;
    }
  });
}
