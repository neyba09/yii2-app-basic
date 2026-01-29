<?php
/**
 * RBAC items configuration file
 * 
 * Roles:
 * - user: обычный пользователь (может создавать, редактировать, удалять книги и авторов)
 * 
 * Permissions:
 * - manageBooks: управление книгами
 * - manageAuthors: управление авторами
 */

return [
    'user' => [
        'type' => 1, // role
        'description' => 'Обычный пользователь',
        'children' => ['manageBooks', 'manageAuthors'],
    ],
    'manageBooks' => [
        'type' => 2, // permission
        'description' => 'Управление книгами',
    ],
    'manageAuthors' => [
        'type' => 2, // permission
        'description' => 'Управление авторами',
    ],
];

