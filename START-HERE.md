# 🎯 НАЧНИТЕ ЗДЕСЬ — Balanz Theme

## ✅ Что было создано

Для вас подготовлена **полностью профессиональная WordPress тема** по стандартам 2026 года:

### 🎨 Готовая структура проекта
- ✅ Кастомная WordPress тема (без page builders)
- ✅ Современная SCSS архитектура
- ✅ JavaScript модули с GSAP анимациями
- ✅ Vite сборка для оптимизации
- ✅ ACF интеграция для CMS

---

## 🚀 Что делать дальше (3 простых шага)

### Шаг 1: Установить локальное окружение

**Windows 11 (рекомендуется):**

1. Скачайте и установите **[Local WP](https://localwp.com/)**
2. Создайте новый сайт в Local:
   ```
   - Site name: balanz
   - PHP: 8.2
   - Web Server: Nginx
   - Domain: balanz.local
   ```

---

### Шаг 2: Установить тему

1. Найдите папку сайта:
   ```
   C:\Users\[ВАШ_USER]\Local Sites\balanz\app\public\
   ```

2. Скопируйте папку `wp-content/themes/balanz` из этого проекта туда

3. В WordPress Admin активируйте тему:
   ```
   Внешний вид → Темы → Активировать "Balanz"
   ```

---

### Шаг 3: Собрать frontend

Откройте Terminal/PowerShell в папке темы:

```bash
cd "C:\Users\[USER]\Local Sites\balanz\app\public\wp-content\themes\balanz"

# Установить зависимости
npm install

# Собрать проект
npm run build

# Или запустить в режиме разработки
npm run watch
```

---

## 📋 Что установить (плагины)

### Обязательные:
1. **Advanced Custom Fields PRO** — для CMS функционала
   - Без него тема не будет работать
   - Скачать: https://www.advancedcustomfields.com/

### Рекомендуемые:
2. **WP Mail SMTP** — для отправки писем с формы
3. **SVG Support** — для загрузки SVG логотипов
4. **Yoast SEO** — для SEO оптимизации

---

## 🎨 Настройка контента

### 1. Настроить ACF поля

Создайте группы полей

### 2. Заполнить контент

```
WP Admin → Страницы → Главная → Редактировать
```

Заполните все поля из макета Figma:
- Заголовки
- Описания
- Изображения
- Ссылки на App Store / Google Play

### 3. Глобальные настройки

```
WP Admin → Настройки темы
```

Укажите:
- Логотип
- Ссылки на приложения (iOS, Android)
- Email для форм
- Соцсети

---

## 🎬 Проверьте, что всё работает

Откройте сайт: `http://balanz.local`

---

## 📱 Работа с макетом Figma

У вас есть макет: https://www.figma.com/design/D9aTZWxKW0yiVPvSa59f0T/Balanz

### Как перенести дизайн:

1. **Цвета** — обновите в `assets/src/scss/abstracts/_variables.scss`
2. **Шрифты** — укажите в `_variables.scss` и `_typography.scss`
3. **Контент** — заполните через ACF в админке
4. **Изображения** — загрузите через медиатеку WP

---

## 🛠 Команды для разработки

```bash
# Разработка (автообновление при изменениях)
npm run watch

# Production сборка (минифицированная)
npm run build

# Dev сервер Vite
npm run dev
```

---

## 📁 Где что находится

```
balanz/
├── assets/
│   ├── src/
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   └── modules/
│   │   │       ├── header.js
│   │   │       ├── mobile-menu.js
│   │   │       ├── scroll-animations.js
│   │   │       ├── how-it-works.js
│   │   │       ├── app-screens.js
│   │   │       ├── testimonials.js
│   │   │       ├── accordion.js
│   │   │       └── share.js
│   │   └── scss/
│   │       ├── abstracts/ (variables, mixins, functions)
│   │       ├── base/ (reset, typography, utilities)
│   │       ├── layout/ (header, footer, grid)
│   │       ├── components/ (buttons, cards, forms)
│   │       ├── sections/ (hero, hiw, why, app, offers, testimonials, cta, about)
│   │       └── animations/
│   └── images/ (загрузи сюда картинки)
├── template-parts/
│   ├── home/ (hero, how-it-works, why-matters, app-screens, offers, testimonials, cta)
│   └── about/ (hero, philosophy, values, how-we-work, team, contact, faq, share)
├── front-page.php
├── page-about-us.php
├── header.php
├── footer.php
└── functions.php
```

## ✨ Фичи темы (готовые к использованию)

### Для администратора:
- ✏️ Полное редактирование контента без кода
- 🖼 Drag-and-drop загрузка изображений
- ➕ Добавление/удаление возможностей (Features)
- 🔗 Управление ссылками на приложения
- 📧 Настройка email для форм

### Для разработчика:
- 🎨 SCSS с переменными и миксинами
- 🔥 Hot Module Replacement (HMR)
- 📦 Модульная архитектура JS
- 🎬 GSAP анимации
- ⚡ Оптимизированная сборка
- 🔄 ACF JSON синхронизация

### Для пользователей:
- 📱 Полностью адаптивный дизайн
- 🎯 Плавные анимации
- ⚡ Быстрая загрузка
- 🔒 Безопасные формы
- ♿ Доступность (Accessibility)
