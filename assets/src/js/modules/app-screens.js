/**
 * App Screens Module
 * - Click navigation to switch screens (like Figma prototype)
 */

export function initAppScreens() {
  const phoneScreen = document.getElementById('appPhoneScreen');
  const navItems = document.querySelectorAll('.app-nav-item');
  
  if (!phoneScreen || !navItems.length) return;
  
  const screens = phoneScreen.querySelectorAll('img');
  
  // Add click listeners to nav items
  navItems.forEach(item => {
    item.addEventListener('click', () => {
      const screenId = item.dataset.screen;
      
      // Update nav items
      navItems.forEach(nav => {
        nav.classList.toggle('is-active', nav === item);
      });
      
      // Update screens
      screens.forEach(screen => {
        const isTarget = screen.dataset.screen === screenId;
        screen.classList.toggle('is-active', isTarget);
        screen.classList.toggle('is-hidden', !isTarget);
      });
    });
  });
}
