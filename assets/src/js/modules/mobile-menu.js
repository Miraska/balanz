/**
 * Mobile Menu Module
 * - Позиционирует mobile-menu на 20px ниже header-inner
 * - Синхронизирует ширину с header-inner
 */

export function initMobileMenu() {
  const toggle = document.getElementById('menuToggle');
  const menu = document.getElementById('mobileMenu');
  const headerInner = document.querySelector('.header-inner');
  
  if (!toggle || !menu || !headerInner) return;
  
  // Обновляем позицию меню относительно header-inner
  function updateMenuPosition() {
    const headerRect = headerInner.getBoundingClientRect();
    const menuOffset = 20; // отступ от header-inner
    
    // Позиция: низ header-inner + 20px отступ
    const topPosition = headerRect.bottom + menuOffset;
    menu.style.top = `${topPosition}px`;
  }
  
  // Обновляем позицию при инициализации
  updateMenuPosition();
  
  // Обновляем позицию при скролле и ресайзе
  window.addEventListener('scroll', updateMenuPosition, { passive: true });
  window.addEventListener('resize', updateMenuPosition, { passive: true });
  
  // Toggle menu
  toggle.addEventListener('click', () => {
    const isOpen = menu.classList.contains('is-open');
    
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  });
  
  // Close on link click
  const links = menu.querySelectorAll('.mobile-nav-link');
  links.forEach(link => {
    link.addEventListener('click', closeMenu);
  });
  
  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
      closeMenu();
    }
  });
  
  // Close on escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeMenu();
    }
  });
  
  function openMenu() {
    updateMenuPosition(); // обновляем позицию перед открытием
    menu.classList.add('is-open');
    toggle.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }
  
  function closeMenu() {
    menu.classList.remove('is-open');
    toggle.classList.remove('is-open');
    document.body.style.overflow = '';
  }
}
