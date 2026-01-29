# Настройка базы данных

## Проблема
Ошибка "Connection refused" означает, что MySQL сервер не запущен или недоступен.

## Решение

### Если используете Vagrant:

1. **Войдите в виртуальную машину:**
   ```bash
   vagrant ssh
   ```

2. **Проверьте статус MySQL:**
   ```bash
   sudo service mysql status
   ```

3. **Если MySQL не запущен, запустите его:**
   ```bash
   sudo service mysql start
   ```

4. **Проверьте, что база данных создана:**
   ```bash
   mysql -u root -e "SHOW DATABASES;"
   ```
   
   Должна быть база данных `yii2basic`

5. **Если база данных не создана, создайте её:**
   ```bash
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS yii2basic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

6. **Выполните миграции:**
   ```bash
   php yii migrate
   ```

### Если используете локальный MySQL (не Vagrant):

1. **Проверьте, запущен ли MySQL:**
   ```bash
   # macOS
   brew services list
   # или
   sudo launchctl list | grep mysql
   ```

2. **Запустите MySQL, если не запущен:**
   ```bash
   # macOS
   brew services start mysql
   # или
   sudo launchctl load -w /Library/LaunchDaemons/com.oracle.oss.mysql.mysqld.plist
   ```

3. **Создайте базу данных:**
   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS yii2basic CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

4. **Обновите конфигурацию в `config/db.php`:**
   - Укажите правильный порт (обычно 3306)
   - Укажите правильный пароль для root

5. **Выполните миграции:**
   ```bash
   php yii migrate
   ```

## Текущая конфигурация БД

Файл `config/db.php` настроен для Vagrant:
- **Хост:** 127.0.0.1
- **Порт:** 3306
- **База данных:** yii2basic
- **Пользователь:** root
- **Пароль:** (пустой)

## Проверка подключения

Проверить подключение к БД можно командой:
```bash
php yii migrate/history
```

Если подключение успешно, вы увидите список выполненных миграций (или пустой список, если миграции еще не выполнялись).

