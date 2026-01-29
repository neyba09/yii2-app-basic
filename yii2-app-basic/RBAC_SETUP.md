# Настройка RBAC

## Инициализация RBAC

Для инициализации RBAC выполните команду:

```bash
php yii rbac/init
```

Эта команда создаст:
- Роль `user` - обычный пользователь
- Разрешения:
  - `manageBooks` - управление книгами
  - `manageAuthors` - управление авторами

## Назначение роли пользователю

Для назначения роли пользователю:

```bash
php yii rbac/assign <userId> [roleName]
```

Пример:
```bash
php yii rbac/assign 1 user
```

## Структура RBAC

Используется `PhpManager` - данные хранятся в файлах:
- `rbac/items.php` - роли и разрешения
- `rbac/assignments.php` - назначения ролей пользователям
- `rbac/rules.php` - правила (если нужны)

## Использование в коде

В контроллерах проверка прав доступа уже настроена через `AccessControl`:

```php
'access' => [
    'class' => AccessControl::class,
    'only' => ['create', 'update', 'delete'],
    'rules' => [
        [
            'allow' => true,
            'roles' => ['@'], // Только авторизованные пользователи
        ],
    ],
],
```

Для проверки конкретных разрешений можно использовать:

```php
if (Yii::$app->user->can('manageBooks')) {
    // Пользователь может управлять книгами
}
```

