<?php
require __DIR__ . '/../config/Database.php';

use Config\Database;

$dbClass = new Database();

$db = $dbClass->getConnection();

require '../vendor/autoload.php';
require __DIR__ . '/../routes/admin.php';
require_once '../routes/routes.php';

?>
