/**
 * Team Slider
 * 
 * 3 фиксированные карточки на своих позициях.
 * При переключении меняется только контент карточек с анимацией.
 * Высота контейнера определяется автоматически по самой высокой карточке.
 * 
 * Позиции:
 * - team-card--active: передняя (активная)
 * - team-card--back-1: первая сзади (клик = следующий)
 * - team-card--back-2: вторая сзади (клик = через одного)
 */

export function initTeam() {
  const slider = document.getElementById("teamSlider");
  if (!slider) return;

  // Получаем данные участников из data-атрибута
  let members = [];
  try {
    const rawData = slider.dataset.members;
    if (rawData) {
      members = JSON.parse(rawData);
    }
  } catch (e) {
    console.error("Team: Failed to parse members data", e);
    return;
  }

  if (!members.length) {
    return;
  }

  // 3 фиксированные карточки
  const cardsContainer = slider.querySelector(".team-cards");
  const cardActive = slider.querySelector(".team-card--active");
  const cardBack1 = slider.querySelector(".team-card--back-1");
  const cardBack2 = slider.querySelector(".team-card--back-2");

  if (!cardActive || !cardsContainer) {
    return;
  }

  // Навигация
  const navItems = Array.from(document.querySelectorAll(".team-nav-item"));
  const navTrack = document.querySelector(".team-nav-track");
  const navWrapper = document.querySelector(".team-nav");

  const total = members.length;
  let current = 0;
  let autoplay = null;

  // Avatar slider state
  let avatarOffset = 0;
  let maxAvatarOffset = 0;
  let minAvatarOffset = 0;
  let isAvatarDragging = false;
  let avatarTouchStartX = 0;
  let avatarStartOffset = 0;

  // Фиксированная высота карточек (рассчитывается один раз)
  let fixedCardHeight = 0;

  init();

  function init() {
    // Дожидаемся загрузки шрифтов перед расчётом высоты
    const startInit = () => {
      // Сначала рассчитать максимальную высоту по всем участникам
      calculateMaxHeight(() => {
        // После расчёта - заполнить карточки и запустить слайдер
        populateCard(cardActive, members[0]);
        populateCard(cardBack1, members[wrapIndex(1)]);
        populateCard(cardBack2, members[wrapIndex(2)]);
        
        updateNav();
        setupEvents();
        startAutoplay();
        
        // Добавляем ResizeObserver для автоматического перерасчёта
        setupResizeObserver();
      });
    };

    // Ждём загрузки шрифтов
    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(() => {
        // Даём ещё один кадр для завершения layout
        requestAnimationFrame(() => {
          requestAnimationFrame(startInit);
        });
      });
    } else {
      // Fallback для браузеров без поддержки document.fonts
      requestAnimationFrame(() => {
        requestAnimationFrame(startInit);
      });
    }
  }

  /**
   * Настройка ResizeObserver для автоматического перерасчёта высоты
   */
  let resizeObserver = null;
  let lastCardWidth = 0;

  function setupResizeObserver() {
    if (!window.ResizeObserver) return;

    lastCardWidth = cardActive.offsetWidth;

    resizeObserver = new ResizeObserver((entries) => {
      for (const entry of entries) {
        const newWidth = entry.contentRect.width;
        
        // Перерасчёт только при изменении ширины
        if (Math.abs(newWidth - lastCardWidth) > 1) {
          lastCardWidth = newWidth;
          calculateMaxHeight();
        }
      }
    });

    resizeObserver.observe(cardActive);
  }

  /**
   * Получить индекс с зацикливанием
   */
  function wrapIndex(index) {
    return ((index % total) + total) % total;
  }

  /**
   * Рассчитать максимальную высоту карточки по всем участникам
   * Создаём временную карточку, рендерим каждого участника и измеряем
   */
  function calculateMaxHeight(callback) {
    // Создаём скрытый контейнер для измерений
    const measureContainer = document.createElement("div");
    measureContainer.style.cssText = `
      position: absolute;
      visibility: hidden;
      pointer-events: none;
      width: ${cardActive.offsetWidth}px;
      left: -9999px;
      top: 0;
    `;
    document.body.appendChild(measureContainer);

    // Клонируем inner структуру активной карточки для измерений
    const innerClone = cardActive.querySelector(".team-card-inner").cloneNode(true);
    innerClone.style.height = "auto";
    measureContainer.appendChild(innerClone);

    let maxHeight = 0;

    // Измеряем высоту для каждого участника
    members.forEach((member) => {
      // Заполняем клон данными участника
      const avatar = innerClone.querySelector(".js-avatar");
      const name = innerClone.querySelector(".js-name");
      const role = innerClone.querySelector(".js-role");
      const quote = innerClone.querySelector(".js-quote");
      const bio = innerClone.querySelector(".js-bio");

      if (avatar) avatar.src = member.avatar;
      if (name) name.textContent = member.name;
      if (role) role.textContent = member.role;
      if (quote) quote.textContent = member.quote;
      if (bio) bio.textContent = member.bio;

      // Измеряем высоту
      const height = innerClone.offsetHeight;
      if (height > maxHeight) {
        maxHeight = height;
      }
    });

    // Удаляем измерительный контейнер
    document.body.removeChild(measureContainer);

    // Сохраняем фиксированную высоту с запасом 20px
    fixedCardHeight = maxHeight + 20;

    // Устанавливаем фиксированную высоту на все карточки
    applyFixedHeight();

    // Вызываем callback
    if (callback) callback();
  }

  /**
   * Применить фиксированную высоту к карточкам и контейнеру
   */
  function applyFixedHeight() {
    const cards = [cardActive, cardBack1, cardBack2].filter(Boolean);
    
    // Устанавливаем высоту inner элементам
    cards.forEach(card => {
      const inner = card.querySelector(".team-card-inner");
      if (inner) {
        inner.style.height = `${fixedCardHeight}px`;
      }
    });

    // Устанавливаем высоту контейнера
    // Desktop: больше места сверху для задних карточек (65px выпирание + запас)
    // Mobile: место снизу для задней карточки (28px выпирание + запас)
    const isDesktop = window.innerWidth >= 1024;
    const containerPadding = isDesktop ? 80 : 35;
    cardsContainer.style.height = `${fixedCardHeight + containerPadding}px`;
  }

  /**
   * Заполнить карточку данными участника
   */
  function populateCard(card, member) {
    if (!card || !member) return;

    const avatar = card.querySelector(".js-avatar");
    const name = card.querySelector(".js-name");
    const role = card.querySelector(".js-role");
    const quote = card.querySelector(".js-quote");
    const bio = card.querySelector(".js-bio");
    const socialContainer = card.querySelector(".js-social");

    if (avatar) {
      avatar.src = member.avatar;
      avatar.alt = member.name;
    }
    if (name) name.textContent = member.name;
    if (role) role.textContent = member.role;
    if (quote) quote.textContent = member.quote;
    if (bio) bio.textContent = member.bio;

    // Социальные ссылки
    if (socialContainer) {
      socialContainer.innerHTML = "";
      if (member.social && member.social.length) {
        member.social.forEach((s) => {
          const link = document.createElement("a");
          link.href = s.url;
          link.target = "_blank";
          link.rel = "noopener";
          link.className = "team-social-link";

          const img = document.createElement("img");
          img.src = s.icon;
          img.alt = s.type;

          link.appendChild(img);
          socialContainer.appendChild(link);
        });
      }
    }
  }

  /**
   * Обновить контент всех 3 карточек с анимацией
   */
  function updateCardsAnimated() {
    // Добавляем класс для fade-out
    cardActive.classList.add("is-changing");
    if (cardBack1) cardBack1.classList.add("is-changing");
    if (cardBack2) cardBack2.classList.add("is-changing");

    // После fade-out меняем контент (200ms = время transition в CSS)
    setTimeout(() => {
      // Обновляем контент
      populateCard(cardActive, members[current]);
      populateCard(cardBack1, members[wrapIndex(current + 1)]);
      populateCard(cardBack2, members[wrapIndex(current + 2)]);

      // Убираем класс для fade-in
      requestAnimationFrame(() => {
        cardActive.classList.remove("is-changing");
        if (cardBack1) cardBack1.classList.remove("is-changing");
        if (cardBack2) cardBack2.classList.remove("is-changing");
      });
    }, 200);
  }

  /**
   * Обновить навигацию
   */
  function updateNav() {
    navItems.forEach((item, i) => {
      item.classList.toggle("is-active", i === current);
    });
    centerActiveAvatar();
  }

  /**
   * Перейти к участнику по индексу
   */
  function goTo(index) {
    const newIndex = wrapIndex(index);
    if (newIndex === current) return;
    
    current = newIndex;
    updateCardsAnimated();
    updateNav();
  }

  function next() {
    goTo(current + 1);
  }

  function prev() {
    goTo(current - 1);
  }

  // ============================================
  // AVATAR SLIDER - Scrollable Navigation
  // ============================================

  /**
   * Calculate avatar slider limits
   */
  function calculateAvatarLimits() {
    if (!navTrack || !navWrapper) return;

    const wrapperWidth = navWrapper.offsetWidth;
    const trackWidth = navTrack.scrollWidth;

    maxAvatarOffset = 0;
    minAvatarOffset = Math.min(0, wrapperWidth - trackWidth);

    // Reset offset if it's out of bounds
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, avatarOffset));
  }

  /**
   * Center the active avatar in view
   */
  function centerActiveAvatar() {
    if (!navTrack || !navWrapper || navItems.length === 0) return;

    calculateAvatarLimits();

    const wrapperWidth = navWrapper.offsetWidth;
    const activeItem = navItems[current];
    
    if (!activeItem) return;

    // Get item position relative to track
    const itemLeft = activeItem.offsetLeft;
    const itemWidth = activeItem.offsetWidth;
    const itemCenter = itemLeft + itemWidth / 2;

    // Calculate offset to center the item
    const desiredOffset = wrapperWidth / 2 - itemCenter;

    // Clamp to limits
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, desiredOffset));

    // Apply transform
    navTrack.style.transform = `translateX(${avatarOffset}px)`;
  }

  /**
   * Update avatar slider position (manual swipe)
   */
  function updateAvatarSliderPosition() {
    if (!navTrack) return;
    navTrack.style.transform = `translateX(${avatarOffset}px)`;
  }

  // ============================================
  // EVENT HANDLERS
  // ============================================

  function setupEvents() {
    // Клик по задним карточкам для переключения
    if (cardBack1) {
      cardBack1.addEventListener("click", () => {
        next();
        resetAutoplay();
      });
    }

    if (cardBack2) {
      cardBack2.addEventListener("click", () => {
        goTo(current + 2);
        resetAutoplay();
      });
    }

    // Клик по навигационным аватаркам
    navItems.forEach((item, i) => {
      item.addEventListener("click", (e) => {
        // Не переключать если был drag
        if (Math.abs(avatarOffset - avatarStartOffset) > 5 && isAvatarDragging) {
          return;
        }
        goTo(i);
        resetAutoplay();
      });
    });

    // Avatar slider - Touch events
    if (navWrapper) {
      navWrapper.addEventListener("touchstart", handleAvatarTouchStart, { passive: true });
      navWrapper.addEventListener("touchmove", handleAvatarTouchMove, { passive: false });
      navWrapper.addEventListener("touchend", handleAvatarTouchEnd, { passive: true });

      // Avatar slider - Mouse events
      navWrapper.addEventListener("mousedown", handleAvatarMouseDown);
      document.addEventListener("mousemove", handleAvatarMouseMove);
      document.addEventListener("mouseup", handleAvatarMouseUp);

      navWrapper.addEventListener("dragstart", (e) => e.preventDefault());
    }

    // Клавиатура
    document.addEventListener("keydown", (e) => {
      if (!slider.matches(":hover")) return;
      if (e.key === "ArrowRight") {
        next();
        resetAutoplay();
      }
      if (e.key === "ArrowLeft") {
        prev();
        resetAutoplay();
      }
    });

    // Пауза автоплея при наведении
    slider.addEventListener("mouseenter", stopAutoplay);
    slider.addEventListener("mouseleave", startAutoplay);

    // Window resize - только для навигации
    // Высота карточек пересчитывается через ResizeObserver
    let resizeTimeout;
    window.addEventListener("resize", () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        calculateAvatarLimits();
        centerActiveAvatar();
        
        // Fallback для браузеров без ResizeObserver
        if (!window.ResizeObserver) {
          calculateMaxHeight();
        }
      }, 250);
    });
  }

  // ============================================
  // AVATAR TOUCH/MOUSE HANDLERS
  // ============================================

  function handleAvatarTouchStart(e) {
    calculateAvatarLimits();
    
    // Only handle if there's overflow
    if (minAvatarOffset >= 0) return;

    avatarTouchStartX = e.changedTouches[0].clientX;
    avatarStartOffset = avatarOffset;
    isAvatarDragging = true;

    if (navTrack) {
      navTrack.classList.add("is-dragging");
    }
  }

  function handleAvatarTouchMove(e) {
    if (!isAvatarDragging) return;

    const currentX = e.changedTouches[0].clientX;
    const diff = currentX - avatarTouchStartX;

    avatarOffset = avatarStartOffset + diff;
    
    // Rubber band effect at edges
    if (avatarOffset > maxAvatarOffset) {
      avatarOffset = maxAvatarOffset + (avatarOffset - maxAvatarOffset) * 0.3;
    } else if (avatarOffset < minAvatarOffset) {
      avatarOffset = minAvatarOffset + (avatarOffset - minAvatarOffset) * 0.3;
    }

    updateAvatarSliderPosition();

    if (Math.abs(diff) > 10) {
      e.preventDefault();
    }
  }

  function handleAvatarTouchEnd() {
    if (!isAvatarDragging) return;

    if (navTrack) {
      navTrack.classList.remove("is-dragging");
    }

    // Snap back to limits if overscrolled
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, avatarOffset));
    updateAvatarSliderPosition();

    isAvatarDragging = false;
  }

  function handleAvatarMouseDown(e) {
    calculateAvatarLimits();
    
    // Only handle if there's overflow
    if (minAvatarOffset >= 0) return;

    e.preventDefault();

    avatarTouchStartX = e.clientX;
    avatarStartOffset = avatarOffset;
    isAvatarDragging = true;

    if (navTrack) {
      navTrack.classList.add("is-dragging");
    }
    if (navWrapper) {
      navWrapper.classList.add("is-grabbing");
    }

    document.body.style.userSelect = "none";
  }

  function handleAvatarMouseMove(e) {
    if (!isAvatarDragging) return;

    e.preventDefault();

    const currentX = e.clientX;
    const diff = currentX - avatarTouchStartX;

    avatarOffset = avatarStartOffset + diff;
    
    // Rubber band effect at edges
    if (avatarOffset > maxAvatarOffset) {
      avatarOffset = maxAvatarOffset + (avatarOffset - maxAvatarOffset) * 0.3;
    } else if (avatarOffset < minAvatarOffset) {
      avatarOffset = minAvatarOffset + (avatarOffset - minAvatarOffset) * 0.3;
    }

    updateAvatarSliderPosition();
  }

  function handleAvatarMouseUp() {
    if (!isAvatarDragging) return;

    if (navTrack) {
      navTrack.classList.remove("is-dragging");
    }
    if (navWrapper) {
      navWrapper.classList.remove("is-grabbing");
    }

    // Snap back to limits if overscrolled
    avatarOffset = Math.max(minAvatarOffset, Math.min(maxAvatarOffset, avatarOffset));
    updateAvatarSliderPosition();

    setTimeout(() => {
      isAvatarDragging = false;
    }, 50);

    document.body.style.userSelect = "";
  }

  // ============================================
  // AUTOPLAY
  // ============================================

  function startAutoplay() {
    if (autoplay) return;
    autoplay = setInterval(next, 6000);
  }

  function stopAutoplay() {
    clearInterval(autoplay);
    autoplay = null;
  }

  function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
  }
}
