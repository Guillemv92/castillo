<?php

namespace App\Models;

use Config\Database;
use PDO;

class Usuario {
    // Autenticación de usuario (como lo tienes)
    public function autenticar($email, $password) {
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT * FROM personas WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $password === $usuario['contrasenha']) {
            return $usuario;
        }
        return false;
    }

    // Registrar un nuevo usuario
    public function registrarUsuario($nombre, $apellido, $email, $telefono, $cedula, $contrasenha) {
        $db = new Database();
        $conn = $db->getConnection();

        // Hash de la contraseña
        $hashedPassword = password_hash($contrasenha, PASSWORD_DEFAULT);

        $query = "INSERT INTO personas (nombre, apellido, email, telefono, cedula, contrasenha) 
                  VALUES (:nombre, :apellido, :email, :telefono, :cedula, :contrasenha)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':contrasenha', $hashedPassword);

        return $stmt->execute();
    }
}
