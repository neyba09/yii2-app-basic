# Маршруты приложения

## Адреса для доступа

### Вариант 1: Встроенный PHP сервер (уже запущен)
```
http://localhost:8080
```

### Вариант 2: Vagrant (если настроен)
```
http://yii2basic.test
или
http://192.168.83.137
```

## Основные маршруты приложения

**Примечание:** Включен Pretty URL, поэтому можно использовать красивые адреса без `index.php?r=`

### Главная страница
- `http://localhost:8080/` или `http://localhost:8080/site/index`

### Книги
- **Список книг:** `http://localhost:8080/book` или `http://localhost:8080/book/index`
- **Просмотр книги:** `http://localhost:8080/book/view?id=1`
- **Добавить книгу (только для авторизованных):** `http://localhost:8080/book/create`
- **Редактировать книгу (только для авторизованных):** `http://localhost:8080/book/update?id=1`
- **Удалить книгу (только для авторизованных):** `http://localhost:8080/book/delete?id=1` (POST запрос)

### Авторы
- **Список авторов:** `http://localhost:8080/author` или `http://localhost:8080/author/index`
- **Просмотр автора:** `http://localhost:8080/author/view?id=1`
- **Добавить автора (только для авторизованных):** `http://localhost:8080/author/create`
- **Редактировать автора (только для авторизованных):** `http://localhost:8080/author/update?id=1`
- **Удалить автора (только для авторизованных):** `http://localhost:8080/author/delete?id=1` (POST запрос)

### Подписка
- **Подписаться на автора:** `http://localhost:8080/subscription/create`

### Отчет
- **ТОП 10 авторов:** `http://localhost:8080/report/top-authors`
- **ТОП 10 авторов за год:** `http://localhost:8080/report/top-authors?year=2024`

### Авторизация
- **Вход:** `http://localhost:8080/site/login`
- **Регистрация:** `http://localhost:8080/site/signup`
- **Выход:** `http://localhost:8080/site/logout` (POST запрос)

## Тестовые данные

После выполнения миграций доступен тестовый пользователь:
- **Логин:** `admin`
- **Пароль:** `admin`

## Примечание

Pretty URL включен в конфигурации. Если нужно использовать старый формат, закомментируйте urlManager в `config/web.php`.

Альтернативный формат (если Pretty URL отключен):
- `http://localhost:8080/index.php?r=book/index`
- `http://localhost:8080/index.php?r=author/view&id=1`

