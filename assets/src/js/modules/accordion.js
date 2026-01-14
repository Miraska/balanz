/**
 * Accordion Module
 * - For Values and FAQ sections
 */

export function initAccordion() {
  // Values Accordion
  initAccordionGroup('#valuesAccordion', '.value-header', '.value-content');
  
  // FAQ Accordion
  initAccordionGroup('#faqAccordion', '.faq-question', '.faq-answer');
}

function initAccordionGroup(containerSelector, triggerSelector, contentSelector) {
  const container = document.querySelector(containerSelector);
  if (!container) return;
  
  const triggers = container.querySelectorAll(triggerSelector);
  
  triggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
      const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
      const content = trigger.nextElementSibling;
      
      // Close all others (optional - for single open)
      triggers.forEach(t => {
        t.setAttribute('aria-expanded', 'false');
        t.nextElementSibling.classList.remove('is-open');
      });
      
      // Toggle current
      if (!isExpanded) {
        trigger.setAttribute('aria-expanded', 'true');
        content.classList.add('is-open');
      }
    });
  });
}
