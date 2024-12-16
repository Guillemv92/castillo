<?php

namespace App\Controllers;

use App\Models\Usuario;

class AuthController {
    // Muestra el formulario de login
    public function mostrarLogin() {
        include_once __DIR__ . '/../Views/login.php';
    }

     // Muestra el formulario de registro
     public function mostrarRegistro() {
        include_once __DIR__ . '/../Views/registro.php';
    }

    // Procesa la autenticación del usuario
    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['name'];
            $password = $_POST['password'];
    
            // Instancia del modelo Usuario
            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->autenticar($email, $password);
    
            if ($usuario) {
                session_start();
                $_SESSION['user'] = [
                    'id' => $usuario['id_persona'], 
                    'nombre' => $usuario['nombre'],
                    'email' => $usuario['email'], 
                    'rol' => $usuario['rol']
                ];
                header("Location: /index.php"); 
                exit();
            } else {
                $error = "Credenciales inválidas. Por favor, intenta de nuevo.";
                include_once __DIR__ . '/../Views/login.php';
            }
        }
    }

     // Procesa el registro del usuario
     public function procesarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $cedula = $_POST['cedula'];
            $contrasenha = $_POST['contrasenha'];

            // Crear instancia del modelo Usuario y registrar
            $usuarioModel = new Usuario();
            $registroExitoso = $usuarioModel->registrarUsuario($nombre, $apellido, $email, $telefono, $cedula, $contrasenha);

            if ($registroExitoso) {
                header("Location: /login");
                exit();
            } else {
                $error = "Error al registrar usuario. Intente nuevamente.";
                include_once __DIR__ . '/../Views/registro.php';
            }
        }
    }

    // Cierra la sesión del usuario
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /index.php");
        exit();
    }
}
