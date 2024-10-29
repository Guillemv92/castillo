<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private $host = "localhost";
    private $dbname = "castillo";
    private $username = "postgres";
    private $password = "password";
    private $conn;

    public function getConnection() {
        if ($this->conn == null) {
            try {
                $this->conn = new PDO("pgsql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }
        return $this->conn;
    }
}
