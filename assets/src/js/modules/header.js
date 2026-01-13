/**
 * Header Module
 * Функционал для шапки сайта
 */

export function initHeader() {
  const header = document.querySelector('.site-header');
  
  if (!header) return;
  
  let lastScrollY = window.scrollY;
  let ticking = false;
  
  function updateHeader() {
    const scrollY = window.scrollY;
    
    // Добавляем класс при скролле
    if (scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
    
    lastScrollY = scrollY;
    ticking = false;
  }
  
  function requestTick() {
    if (!ticking) {
      window.requestAnimationFrame(updateHeader);
      ticking = true;
    }
  }
  
  window.addEventListener('scroll', requestTick, { passive: true });
  
  // Инициализация
  updateHeader();
  
  console.log('📋 Header initialized');
}
