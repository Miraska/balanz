/**
 * Contact Form Module
 * Обработка формы обратной связи
 */

export function initContactForm() {
  const form = document.getElementById('contactForm');
  
  if (!form) return;
  
  const submitButton = form.querySelector('.btn-submit');
  const messageContainer = form.querySelector('.form-message');
  
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Получаем данные формы
    const formData = new FormData(form);
    const data = {
      action: 'balanz_contact_form',
      nonce: window.balanzData.nonce,
      name: formData.get('name'),
      email: formData.get('email'),
      message: formData.get('message')
    };
    
    // Валидация на клиенте
    if (!data.name || !data.email || !data.message) {
      showMessage('Пожалуйста, заполните все поля', 'error');
      return;
    }
    
    if (!isValidEmail(data.email)) {
      showMessage('Пожалуйста, введите корректный email', 'error');
      return;
    }
    
    // Показываем загрузку
    submitButton.classList.add('loading');
    submitButton.disabled = true;
    
    try {
      // Отправка через WordPress AJAX
      const response = await fetch(window.balanzData.ajaxUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(data)
      });
      
      const result = await response.json();
      
      if (result.success) {
        showMessage(result.data.message, 'success');
        form.reset();
      } else {
        showMessage(result.data.message || 'Произошла ошибка. Попробуйте позже.', 'error');
      }
    } catch (error) {
      console.error('Form submission error:', error);
      showMessage('Произошла ошибка. Попробуйте позже.', 'error');
    } finally {
      // Убираем загрузку
      submitButton.classList.remove('loading');
      submitButton.disabled = false;
    }
  });
  
  /**
   * Показать сообщение
   */
  function showMessage(message, type) {
    messageContainer.textContent = message;
    messageContainer.className = `form-message show ${type}`;
    
    // Автоматически скрыть через 5 секунд
    setTimeout(() => {
      messageContainer.classList.remove('show');
    }, 5000);
  }
  
  /**
   * Валидация email
   */
  function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }
  
  console.log('📧 Contact form initialized');
}
