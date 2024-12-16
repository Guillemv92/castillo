<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private $conn;

    public function getConnection() {
        if ($this->conn == null) {
            // Cargar configuración
            $config = require __DIR__ . '/config.php';
            $dbConfig = $config['db'];

            try {
                $dsn = "pgsql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}";
                $this->conn = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }
        return $this->conn;
    }
}
