<?php

if (file_exists(__DIR__ . '/database-local.php')) {
    return (require __DIR__ . '/database-local.php');
}

return [
    'base.db.type' => env('DB_TYPE', 'mysql.name'),
    'mutex.db.type' => env('DB_MUTEX', 'mysql.name'),
    'redis.db.type' => env('DB_REDIS', 'redis.name'),

    'db.settings.list' => [

        'mysql.name' => [
            'mysql:host=' . env('MYSQL_HOST', 'db'), // Используем env() для хоста
            'port=' . env('MYSQL_PORT', '3306'),     // Используем env() для порта
            'dbname=' . env('MYSQL_DATABASE', ''),     // Используем env() для имени БД
            'charset=utf8',
            'user' => env('MYSQL_USER', ''),           // Используем env() для пользователя
            'pass' => env('MYSQL_PASSWORD', ''),       // Используем env() для пароля
            'options' => [
            // \PDO::ATTR_PERSISTENT => TRUE
            ],
        ],

        'sqlite.name' => [
            'sqlite:c:/main.db',
            'user' => '%username%',
            'pass' => '%password%',
            'options' => [],
        ],

        'postgresql.name' => [
            'pgsql:host=127.0.0.1',
            'port=5432',
            'dbname=%dbname%',
            'user' => '%username%',
            'pass' => '%password%',
            'options' => [],
        ],

        'mysql.sphinx-search' => [
            'mysql:host=127.0.0.1',
            'port=9306',
            'user' => '%username%',
            'pass' => '%password%',
            'options' => [],
        ],

        'redis.name' => [
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => '6379',
         // 'password' => '%password%',
            'options' => [],
        ],

    ]];