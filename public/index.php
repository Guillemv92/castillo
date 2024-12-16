<?php

require(__DIR__ . '/../config/database.php');

use Config\Database;


$dbClass = new Database();
$db = $dbClass->getConnection();


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


require '../vendor/autoload.php';

// Separar rutas según el contexto
if (strpos($url, '/admin') === 0) {
    // Rutas administrativas
    require_once __DIR__ . '/../routes/admin.php';
} else {
    // Rutas públicas
    require_once __DIR__ . '/../routes/routes.php';
}
?>
