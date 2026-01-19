/**
 * Header Module
 * - Position relative to hero-bg with 24px offset
 * - Becomes fixed at 20px from top on scroll
 * - Expands to full width when fixed
 */

export function initHeader() {
  const header = document.getElementById("siteHeader");
  const heroBg = document.querySelector(".hero-bg");

  if (!header) return;

  const STICKY_TOP = 20; // фиксированная позиция от верха экрана
  const HEADER_OFFSET = 14; // отступ от верха hero-bg (уменьшено для более высокого положения)

  // Если нет hero-bg (не главная страница) - фиксированный header
  if (!heroBg) {
    header.style.transform = `translateY(${STICKY_TOP}px)`;

    // Показываем header после установки позиции
    requestAnimationFrame(() => {
      header.classList.add("is-ready");
    });

    function handleSimpleScroll() {
      if (window.pageYOffset > 50) {
        header.classList.add("is-scrolled");
      } else {
        header.classList.remove("is-scrolled");
      }
    }

    handleSimpleScroll();
    window.addEventListener("scroll", handleSimpleScroll, { passive: true });
    return;
  }

  // Главная страница с hero
  let heroBgTop = 0;

  function calculatePositions() {
    const rect = heroBg.getBoundingClientRect();
    heroBgTop = window.pageYOffset + rect.top;
  }

  function updateHeader() {
    const scroll = window.pageYOffset;

    // Где должен быть header: верх hero-bg + 24px - скролл
    const targetY = heroBgTop + HEADER_OFFSET - scroll;

    // Не выше чем STICKY_TOP (20px)
    const y = Math.max(targetY, STICKY_TOP);

    header.style.transform = `translateY(${y}px)`;

    // Класс is-scrolled когда header зафиксирован
    if (y <= STICKY_TOP) {
      header.classList.add("is-scrolled");
    } else {
      header.classList.remove("is-scrolled");
    }
  }

  // Инициализация
  calculatePositions();
  updateHeader();

  // Показываем header после установки позиции
  requestAnimationFrame(() => {
    header.classList.add("is-ready");
  });

  // Пересчет при resize
  window.addEventListener(
    "resize",
    () => {
      calculatePositions();
      updateHeader();
    },
    { passive: true }
  );

  // Обновление при скролле - БЕЗ throttle для мгновенной реакции
  window.addEventListener("scroll", updateHeader, { passive: true });
}
