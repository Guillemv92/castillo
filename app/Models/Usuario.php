<?php

namespace App\Models;

use Config\Database;
use PDO;

class Usuario {
    // Autenticación de usuario 
    public function autenticar($email, $password) {
        $db = new Database();
        $conn = $db->getConnection();
    
        // Seleccionar solo los campos necesarios
        $query = "SELECT id_persona, nombre, email, contrasenha, rol FROM personas WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar si el usuario existe y la contraseña coincide
        if ($usuario && password_verify($password, $usuario['contrasenha'])) {
            unset($usuario['contrasenha']); 
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
        $rol = 'C';

        $query = "INSERT INTO personas (nombre, apellido, email, telefono, cedula, contrasenha, rol) 
                  VALUES (:nombre, :apellido, :email, :telefono, :cedula, :contrasenha, :rol)";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':contrasenha', $hashedPassword);
        $stmt->bindParam(':rol', $rol);

        return $stmt->execute();
    }
}
