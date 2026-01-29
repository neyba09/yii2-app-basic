<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    /**
     * Инициализация RBAC
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Очищаем старые данные
        $auth->removeAll();

        // Создаем разрешения
        $manageBooks = $auth->createPermission('manageBooks');
        $manageBooks->description = 'Управление книгами';
        $auth->add($manageBooks);

        $manageAuthors = $auth->createPermission('manageAuthors');
        $manageAuthors->description = 'Управление авторами';
        $auth->add($manageAuthors);

        // Создаем роль user
        $user = $auth->createRole('user');
        $user->description = 'Обычный пользователь';
        $auth->add($user);

        // Назначаем разрешения роли user
        $auth->addChild($user, $manageBooks);
        $auth->addChild($user, $manageAuthors);

        Console::output('RBAC инициализирован успешно!');
        Console::output('Создана роль: user');
        Console::output('Созданы разрешения: manageBooks, manageAuthors');
    }

    /**
     * Назначить роль пользователю
     * @param int $userId ID пользователя
     * @param string $roleName Имя роли
     */
    public function actionAssign($userId, $roleName = 'user')
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);

        if (!$role) {
            Console::error("Роль '{$roleName}' не найдена!");
            return 1;
        }

        try {
            $auth->assign($role, $userId);
            Console::output("Роль '{$roleName}' успешно назначена пользователю с ID {$userId}");
        } catch (\Exception $e) {
            Console::error("Ошибка: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

