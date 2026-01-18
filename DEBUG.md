# Отладка формы "Share with Balanz"

## Проверьте в браузере:

### 1. Откройте консоль разработчика (F12)

### 2. Проверьте, что `balanzData` передан:
В консоли напишите:
```javascript
console.log(window.balanzData)
```

**Должно вывести:**
```javascript
{
  ajaxUrl: "/wp-admin/admin-ajax.php",
  nonce: "какой-то хеш",
  themeUrl: "http://ваш-сайт/wp-content/themes/balanz"
}
```

### 3. Проверьте ошибки при отправке формы:
- Откройте вкладку **Network** (Сеть)
- Заполните форму и нажмите отправить
- Найдите запрос `admin-ajax.php`
- Посмотрите:
  - **Status** (статус) — должен быть 200
  - **Response** (ответ) — что сервер вернул

---

## Возможные проблемы:

### ❌ Если `balanzData` = undefined
**Проблема:** JavaScript не подключен или `wp_localize_script` не работает

**Решение:** Проверьте, что в `<head>` страницы есть:
```html
<script>
var balanzData = {"ajaxUrl":"...","nonce":"...","themeUrl":"..."};
</script>
```

Если нет — проблема в `functions.php` (строка 106-110)

---

### ❌ Если Status = 400 (Bad Request)
**Проблема:** Nonce невалиден или данные формы неправильные

**Решение:** 
- Очистите кэш
- Обновите страницу (Ctrl+F5)
- Попробуйте снова

---

### ❌ Если Status = 403 (Forbidden)
**Проблема:** Nonce проверка провалилась

**Решение:**
- Проверьте, что в настройках WordPress включены cookies
- Попробуйте в режиме инкогнито

---

### ❌ Если Status = 0 (Network Error)
**Проблема:** Сетевая ошибка, AJAX URL неправильный

**Решение:**
- Проверьте, что AJAX URL правильный
- Проверьте .htaccess файл

---

### ❌ Если Response = {"success":false}
**Проблема:** Серверная валидация не прошла

**Решение:** Посмотрите `result.data.errors` в консоли — там будет описание ошибки

---

## Быстрый тест AJAX:

Вставьте в консоль браузера:

```javascript
fetch('/wp-admin/admin-ajax.php', {
  method: 'POST',
  headers: {'Content-Type': 'application/x-www-form-urlencoded'},
  body: new URLSearchParams({
    action: 'balanz_share_form',
    nonce: window.balanzData.nonce,
    name: 'Test User',
    contact: 'test@example.com',
    message: 'Test message',
    subscribe: 'false'
  })
})
.then(r => r.json())
.then(data => console.log('Result:', data))
.catch(err => console.error('Error:', err));
```

**Должно вернуть:**
```javascript
{success: true, data: {message: "Thank you! Your message has been sent successfully."}}
```
