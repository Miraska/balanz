/**
 * Mobile Menu Module
 * Мобильное меню
 */

export function initMobileMenu() {
  const toggle = document.querySelector('.mobile-menu-toggle');
  const navLinks = document.querySelectorAll('.nav-link');
  
  if (!toggle) return;
  
  // Создаем мобильное меню если его нет
  let mobileMenu = document.querySelector('.mobile-menu');
  
  if (!mobileMenu) {
    mobileMenu = document.createElement('div');
    mobileMenu.className = 'mobile-menu';
    
    const navList = document.querySelector('.nav-list');
    if (navList) {
      mobileMenu.appendChild(navList.cloneNode(true));
      document.body.appendChild(mobileMenu);
    }
  }
  
  // Toggle menu
  toggle.addEventListener('click', () => {
    toggle.classList.toggle('active');
    mobileMenu.classList.toggle('active');
    document.body.classList.toggle('menu-open');
  });
  
  // Закрытие при клике на ссылку
  const mobileNavLinks = mobileMenu.querySelectorAll('.nav-link');
  
  mobileNavLinks.forEach(link => {
    link.addEventListener('click', () => {
      toggle.classList.remove('active');
      mobileMenu.classList.remove('active');
      document.body.classList.remove('menu-open');
    });
  });
  
  // Закрытие при клике вне меню
  mobileMenu.addEventListener('click', (e) => {
    if (e.target === mobileMenu) {
      toggle.classList.remove('active');
      mobileMenu.classList.remove('active');
      document.body.classList.remove('menu-open');
    }
  });
  
  // Закрытие при Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && mobileMenu.classList.contains('active')) {
      toggle.classList.remove('active');
      mobileMenu.classList.remove('active');
      document.body.classList.remove('menu-open');
    }
  });
  
  console.log('📱 Mobile menu initialized');
}
