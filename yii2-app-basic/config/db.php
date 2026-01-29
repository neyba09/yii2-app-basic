<?php

$host = getenv('MYSQL_HOST') ?: '127.0.0.1';
$port = getenv('MYSQL_PORT') ?: 3306;
$dbname = getenv('MYSQL_DB') ?: 'yii2basic';
$username = getenv('MYSQL_USER') ?: 'root';
$password = getenv('MYSQL_PASS') ?: 'root';

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4",
    'username' => $username,
    'password' => $password,
    'attributes' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ],
];
