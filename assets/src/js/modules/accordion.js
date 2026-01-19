/**
 * Accordion Module
 * - For Values and FAQ sections
 */

export function initAccordion() {
  // Values Accordion
  initAccordionGroup("#valuesAccordion", ".value-header", ".value-content");

  // FAQ Accordion - New design with is-active class on item
  initFaqAccordion();
}

function initAccordionGroup(containerSelector, triggerSelector, contentSelector) {
  const container = document.querySelector(containerSelector);
  if (!container) return;

  const triggers = container.querySelectorAll(triggerSelector);

  triggers.forEach((trigger) => {
    trigger.addEventListener("click", () => {
      const isExpanded = trigger.getAttribute("aria-expanded") === "true";
      const content = trigger.nextElementSibling;

      // Close all others (optional - for single open)
      triggers.forEach((t) => {
        t.setAttribute("aria-expanded", "false");
        t.nextElementSibling.classList.remove("is-open");
      });

      // Toggle current
      if (!isExpanded) {
        trigger.setAttribute("aria-expanded", "true");
        content.classList.add("is-open");
      }
    });
  });
}

/**
 * FAQ Accordion - New design
 * Uses .is-active class on .faq-item for styling
 */
function initFaqAccordion() {
  const container = document.querySelector("#faqAccordion");
  if (!container) return;

  const items = container.querySelectorAll(".faq-item");
  const buttons = container.querySelectorAll(".faq-question");

  buttons.forEach((button, index) => {
    button.addEventListener("click", () => {
      const item = items[index];
      const isActive = item.classList.contains("is-active");

      // Close all items
      items.forEach((i) => {
        i.classList.remove("is-active");
        i.querySelector(".faq-question").setAttribute("aria-expanded", "false");
      });

      // Toggle current (if wasn't active, open it)
      if (!isActive) {
        item.classList.add("is-active");
        button.setAttribute("aria-expanded", "true");
      }
    });
  });
}
