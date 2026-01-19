# Balanz - Production Checklist

## 🔧 Настройка перед передачей клиенту

### 1. Настройки WordPress (в админке)

#### Общие настройки (Settings → General)
- [ ] **Site Title**: Balanz
- [ ] **Tagline**: Smart food for busy people who want to eat well
- [ ] **WordPress Address (URL)**: https://findbalanz.com
- [ ] **Site Address (URL)**: https://findbalanz.com
- [ ] **Timezone**: выбрать нужный часовой пояс

#### Настройки чтения (Settings → Reading)
- [ ] **Your homepage displays**: A static page
- [ ] **Homepage**: Home
- [ ] **Search engine visibility**: НЕ отмечено (чтобы индексировались)

#### Постоянные ссылки (Settings → Permalinks)
- [ ] **Permalink structure**: Post name (/%postname%/)

---

### 2. Настройки темы (Theme Settings)

#### Theme Settings → SEO Settings
- [ ] **Default Meta Description**: заполнено
- [ ] **Default OG Image**: загружено (1200x630px)
- [ ] **Home Page Title**: заполнено
- [ ] **Home Page Description**: заполнено

#### Theme Settings → App Links
- [ ] **App Store Link**: реальная ссылка
- [ ] **Google Play Link**: реальная ссылка
- [ ] **Download Button Link**: реальная ссылка

#### Theme Settings → Contact Info
- [ ] Email для формы обратной связи

#### Theme Settings → Social Links
- [ ] Ссылки на социальные сети (при наличии)

#### Theme Settings → Form Settings (SMTP)
Для отправки писем с формы:
- [ ] **SMTP Host**: smtp.timeweb.ru (или ваш SMTP сервер)
- [ ] **SMTP Port**: 587 (или 465 для SSL)
- [ ] **SMTP Username**: ваш email
- [ ] **SMTP Password**: пароль от почты
- [ ] **From Email**: noreply@findbalanz.com
- [ ] **From Name**: Balanz

---

### 3. Очистка от лишнего

#### Плагины (Plugins)
- [ ] Оставить только: **Advanced Custom Fields PRO**
- [ ] Удалить все остальные плагины (Hello Dolly, Akismet и т.д.)

#### Темы (Appearance → Themes)
- [ ] Оставить только: **Balanz**
- [ ] Удалить: Twenty Twenty-Four, Twenty Twenty-Three и т.д.

#### Медиафайлы (Media)
- [ ] Удалить неиспользуемые изображения

#### Пользователи (Users)
- [ ] Создать аккаунт для клиента (роль: Editor или Administrator)
- [ ] Удалить тестовые аккаунты
- [ ] Изменить стандартный username "admin" на что-то уникальное

---

### 4. Настройка хостинга Timeweb

#### SSL сертификат
1. Панель управления → SSL-сертификаты
2. Выпустить бесплатный Let's Encrypt сертификат
3. Включить принудительный HTTPS редирект

#### PHP настройки
Рекомендуемые настройки (Панель → PHP):
```
PHP version: 8.1 или 8.2
memory_limit: 256M
max_execution_time: 300
upload_max_filesize: 64M
post_max_size: 64M
```

#### Кэширование
В панели Timeweb:
1. Включить кэширование статики (CSS, JS, изображения)
2. Установить срок кэша: 1 год для статики

#### Сжатие GZIP
Добавить в `.htaccess` (обычно уже есть):
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
    AddOutputFilterByType DEFLATE application/javascript application/x-javascript
    AddOutputFilterByType DEFLATE application/xml application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml application/atom+xml
    AddOutputFilterByType DEFLATE image/svg+xml
</IfModule>
```

#### Кэширование браузера
Добавить в `.htaccess`:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType image/x-icon "access plus 1 year"
    ExpiresDefault "access plus 2 days"
</IfModule>
```

---

### 5. Безопасность

#### wp-config.php
Добавить перед строкой `/* That's all, stop editing! */`:
```php
// Security Keys (сгенерировать на https://api.wordpress.org/secret-key/1.1/salt/)
// Замените существующие ключи на новые!

// Disable file editing in admin
define('DISALLOW_FILE_EDIT', true);

// Limit post revisions
define('WP_POST_REVISIONS', 3);

// Disable debug on production
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
```

#### Защита файлов
Добавить в `.htaccess`:
```apache
# Protect wp-config.php
<files wp-config.php>
order allow,deny
deny from all
</files>

# Protect .htaccess
<files .htaccess>
order allow,deny
deny from all
</files>

# Disable directory browsing
Options -Indexes

# Block access to sensitive files
<FilesMatch "^(readme|license|changelog)\.(html|txt|md)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

#### Смена префикса таблиц (если новая установка)
Если возможно, изменить `$table_prefix = 'wp_';` на что-то уникальное, например `$table_prefix = 'blz_';`

---

### 6. SEO - Индексация в поисковиках

#### Google Search Console
1. Перейти на https://search.google.com/search-console
2. Добавить ресурс: https://findbalanz.com
3. Подтвердить владение (HTML файл или DNS запись)
4. Отправить sitemap: https://findbalanz.com/sitemap.xml

#### Yandex Webmaster
1. Перейти на https://webmaster.yandex.ru
2. Добавить сайт: https://findbalanz.com
3. Подтвердить владение
4. Отправить sitemap

#### Проверка индексации
- Sitemap: https://findbalanz.com/sitemap.xml
- Robots.txt: https://findbalanz.com/robots.txt
- Оба файла генерируются автоматически темой

---

### 7. Финальная проверка

#### Функциональность
- [ ] Главная страница загружается корректно
- [ ] Страница About Us работает
- [ ] Форма обратной связи отправляет письма
- [ ] Все ссылки работают
- [ ] Мобильная версия отображается правильно

#### SEO проверка
- [ ] OG-теги работают (проверить через Facebook Debugger)
- [ ] Sitemap доступен
- [ ] Robots.txt корректный
- [ ] SSL работает (зеленый замок)

#### Скорость
Проверить на:
- [ ] https://pagespeed.web.dev/
- [ ] https://gtmetrix.com/

---

### 8. Передача клиенту

#### Создать документацию
- Логин/пароль от админки
- Логин/пароль от хостинга
- Как редактировать контент
- Контакты разработчика для поддержки

#### Создать аккаунт для клиента
1. Users → Add New
2. Role: Administrator (или Editor если нужно ограничить)
3. Отправить данные клиенту

#### Рекомендации клиенту
- Регулярно обновлять WordPress и плагины
- Делать бекапы (настроить на хостинге)
- Не устанавливать непроверенные плагины

---

## 📧 Настройка SMTP на Timeweb

### Вариант 1: Почта Timeweb
1. Создать почтовый ящик в панели Timeweb
2. Использовать настройки:
   - Host: smtp.timeweb.ru
   - Port: 587
   - Username: ваш@домен.ru
   - Password: пароль от почты

### Вариант 2: Gmail (для тестирования)
1. Включить двухфакторную аутентификацию в Google
2. Создать "App Password"
3. Использовать настройки:
   - Host: smtp.gmail.com
   - Port: 587
   - Username: your@gmail.com
   - Password: App Password (не основной пароль!)

---

## 🔄 После запуска

### Еженедельно
- Проверять работу формы
- Проверять наличие обновлений

### Ежемесячно
- Обновлять WordPress (после бекапа)
- Обновлять ACF Pro (после бекапа)
- Проверять скорость загрузки

### При необходимости
- Обновлять контент
- Добавлять новые изображения
