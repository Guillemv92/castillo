<?php
// config/config.php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'postgres.railway.internal',
        'dbname' => $_ENV['DB_NAME'] ?? 'railway',
        'username' => $_ENV['DB_USERNAME'] ?? 'postgres',
        'password' => $_ENV['DB_PASSWORD'] ?? 'xOLWoqUficeJXphwKkezKlKBnJNQtlCR',
    ],
];
