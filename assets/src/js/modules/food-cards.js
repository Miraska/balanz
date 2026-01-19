/**
 * Food Cards Animation Module
 * Простые плавные анимации для food cards - аналогично телефонам в CTA
 */

export function initFoodCards() {
  const whySection = document.querySelector(".why-section");
  if (!whySection) return;

  const foodCard1 = whySection.querySelector(".food-card-1");
  const foodCard2 = whySection.querySelector(".food-card-2");
  const cards = [foodCard1, foodCard2].filter(Boolean);

  if (!cards.length) return;

  let hasAnimated = false;

  // Intersection Observer для появления карточек
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !hasAnimated) {
          animateCards();
          hasAnimated = true;
        }
      });
    },
    {
      threshold: 0.3,
      rootMargin: "0px 0px -50px 0px",
    }
  );

  observer.observe(whySection);

  function animateCards() {
    // Анимация появления с задержкой
    if (foodCard1) {
      setTimeout(() => {
        foodCard1.classList.add("animate-in");
      }, 100);
    }

    if (foodCard2) {
      setTimeout(() => {
        foodCard2.classList.add("animate-in");
      }, 250);
    }
  }

  // Плавный параллакс при скролле (как у телефонов)
  let ticking = false;

  function updateCardPositions() {
    const rect = whySection.getBoundingClientRect();
    const scrollPercent = 1 - rect.top / window.innerHeight;

    if (scrollPercent > 0 && scrollPercent < 1.5) {
      const parallaxY1 = scrollPercent * 15 - 15;
      const parallaxY2 = scrollPercent * 20 - 20;

      if (foodCard1 && foodCard1.classList.contains("animate-in")) {
        foodCard1.style.transform = `translateY(${parallaxY1}px)`;
      }

      if (foodCard2 && foodCard2.classList.contains("animate-in")) {
        foodCard2.style.transform = `translateY(${parallaxY2}px)`;
      }
    }

    ticking = false;
  }

  window.addEventListener("scroll", () => {
    if (!ticking && hasAnimated) {
      window.requestAnimationFrame(updateCardPositions);
      ticking = true;
    }
  });
}
