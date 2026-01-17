/**
 * Share with Balanz Module
 * - Form validation
 * - AJAX submission to WordPress
 * - Input clear buttons
 * - Input states (active, filled)
 * - Success modal display
 */

export function initShare() {
  initShareForm();
  initInputClearButtons();
  initInputStates();
}

/**
 * Validation rules
 */
const validators = {
  name: {
    validate: (value) => {
      if (!value.trim()) return 'Please enter your name.';
      if (value.trim().length < 2) return 'Name must be at least 2 characters.';
      if (value.trim().length > 100) return 'Name is too long.';
      return null;
    }
  },
  contact: {
    validate: (value) => {
      if (!value.trim()) return 'Please enter your phone number or email.';
      
      // Check if email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const isEmail = emailRegex.test(value.trim());
      
      // Check if phone (7-15 digits, allowing spaces, dashes, parentheses, plus)
      const phoneClean = value.replace(/[\s\-\(\)\+]/g, '');
      const isPhone = /^[0-9]{7,15}$/.test(phoneClean);
      
      if (!isEmail && !isPhone) {
        return 'Please enter a valid email or phone number.';
      }
      
      return null;
    }
  },
  message: {
    validate: (value) => {
      if (value && value.length > 2000) return 'Message is too long (max 2000 characters).';
      return null;
    }
  }
};

/**
 * Show field error
 */
function showFieldError(field, message) {
  const formGroup = field.closest('.swb-form-group');
  if (!formGroup) return;
  
  // Remove existing error
  clearFieldError(field);
  
  // Add error class to input
  field.classList.add('is-error');
  
  // Create error message element
  const errorEl = document.createElement('span');
  errorEl.className = 'swb-field-error';
  errorEl.textContent = message;
  
  formGroup.appendChild(errorEl);
}

/**
 * Clear field error
 */
function clearFieldError(field) {
  const formGroup = field.closest('.swb-form-group');
  if (!formGroup) return;
  
  field.classList.remove('is-error');
  
  const existingError = formGroup.querySelector('.swb-field-error');
  if (existingError) {
    existingError.remove();
  }
}

/**
 * Validate single field
 */
function validateField(field) {
  const fieldName = field.name;
  const validator = validators[fieldName];
  
  if (!validator) return true;
  
  const error = validator.validate(field.value);
  
  if (error) {
    showFieldError(field, error);
    return false;
  }
  
  clearFieldError(field);
  return true;
}

/**
 * Validate entire form
 */
function validateForm(form) {
  const fields = form.querySelectorAll('.swb-input, .swb-textarea');
  let isValid = true;
  let firstInvalidField = null;
  
  fields.forEach(field => {
    const fieldValid = validateField(field);
    if (!fieldValid && isValid) {
      isValid = false;
      firstInvalidField = field;
    }
  });
  
  // Focus first invalid field
  if (firstInvalidField) {
    firstInvalidField.focus();
  }
  
  return isValid;
}

/**
 * Initialize form submission
 */
function initShareForm() {
  const form = document.getElementById('shareWithBalanzForm');
  const card = form?.closest('.swb-card');
  
  if (!form || !card) return;
  
  // Real-time validation on blur
  const fields = form.querySelectorAll('.swb-input, .swb-textarea');
  fields.forEach(field => {
    field.addEventListener('blur', () => {
      // Only validate if field has been touched (has value or was focused)
      if (field.value || field.dataset.touched) {
        validateField(field);
      }
    });
    
    field.addEventListener('focus', () => {
      field.dataset.touched = 'true';
    });
    
    // Clear error on input
    field.addEventListener('input', () => {
      if (field.classList.contains('is-error')) {
        clearFieldError(field);
      }
    });
  });
  
  // Form submission
  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Validate form
    if (!validateForm(form)) {
      return;
    }
    
    // Get form data
    const formData = new FormData(form);
    
    // Disable submit button and show loading state
    const submitBtn = form.querySelector('.swb-submit');
    const originalBtnContent = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
      <span>Sending...</span>
      <span class="swb-submit-spinner"></span>
    `;
    
    try {
      // Prepare data for AJAX
      const data = new URLSearchParams();
      data.append('action', 'balanz_share_form');
      data.append('nonce', window.balanzData?.nonce || '');
      data.append('name', formData.get('name'));
      data.append('contact', formData.get('contact'));
      data.append('message', formData.get('message') || '');
      data.append('subscribe', formData.get('subscribe') ? 'true' : 'false');
      
      // Send AJAX request
      const response = await fetch(window.balanzData?.ajaxUrl || '/wp-admin/admin-ajax.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data.toString()
      });
      
      const result = await response.json();
      
      if (result.success) {
        // Show success state
        card.classList.add('is-success');
        
        // Reset form
        form.reset();
        
        // Reset input states
        form.querySelectorAll('.swb-input, .swb-textarea').forEach(input => {
          input.classList.remove('is-active', 'is-filled', 'is-error');
          delete input.dataset.touched;
        });
        
        // Remove any error messages
        form.querySelectorAll('.swb-field-error').forEach(el => el.remove());
        
      } else {
        // Handle validation errors from server
        if (result.data?.errors) {
          Object.entries(result.data.errors).forEach(([fieldName, message]) => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
              showFieldError(field, message);
            }
          });
          
          // Focus first error field
          const firstError = form.querySelector('.is-error');
          if (firstError) firstError.focus();
        } else {
          // Show general error
          showFormMessage(form, result.data?.message || 'Something went wrong. Please try again.', 'error');
        }
      }
      
    } catch (error) {
      console.error('Form submission error:', error);
      showFormMessage(form, 'Network error. Please check your connection and try again.', 'error');
    } finally {
      // Restore button
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnContent;
    }
  });
}

/**
 * Show form-level message (for network errors, etc.)
 */
function showFormMessage(form, message, type = 'error') {
  // Remove existing message
  const existingMessage = form.querySelector('.swb-form-message');
  if (existingMessage) existingMessage.remove();
  
  const messageEl = document.createElement('div');
  messageEl.className = `swb-form-message swb-form-message--${type}`;
  messageEl.textContent = message;
  
  // Insert before submit button
  const submitBtn = form.querySelector('.swb-submit');
  if (submitBtn) {
    submitBtn.parentNode.insertBefore(messageEl, submitBtn);
  } else {
    form.appendChild(messageEl);
  }
  
  // Auto-remove after 5 seconds
  setTimeout(() => {
    messageEl.remove();
  }, 5000);
}

/**
 * Initialize input clear buttons
 */
function initInputClearButtons() {
  const clearButtons = document.querySelectorAll('.swb-input-clear');
  
  clearButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const wrapper = btn.closest('.swb-input-wrapper');
      const input = wrapper?.querySelector('.swb-input');
      
      if (input) {
        input.value = '';
        input.classList.remove('is-filled', 'is-active');
        clearFieldError(input);
        input.focus();
        
        // Trigger input event for any listeners
        input.dispatchEvent(new Event('input', { bubbles: true }));
      }
    });
  });
}

/**
 * Initialize input states (active when typing, filled when has value)
 */
function initInputStates() {
  const inputs = document.querySelectorAll('.swb-input');
  
  inputs.forEach(input => {
    // Focus state - add active class
    input.addEventListener('focus', () => {
      if (input.value.trim()) {
        input.classList.add('is-active');
      }
    });
    
    // Blur state - check if filled
    input.addEventListener('blur', () => {
      input.classList.remove('is-active');
      
      if (input.value.trim()) {
        input.classList.add('is-filled');
      } else {
        input.classList.remove('is-filled');
      }
    });
    
    // Input state - add active while typing
    input.addEventListener('input', () => {
      if (document.activeElement === input && input.value.trim()) {
        input.classList.add('is-active');
      } else if (!input.value.trim()) {
        input.classList.remove('is-active');
      }
    });
    
    // Check initial state
    if (input.value.trim()) {
      input.classList.add('is-filled');
    }
  });
}
