<?php 
class CConexion {
    // Definimos las propiedades con su visibilidad
    private $host = "localhost";
    private $dbname = "castillo";
    private $username = "postgres";
    private $password = "password";

    // Aquí puedes agregar métodos para conectarte a la base de datos si es necesario
    public function getConnection() {
        try {
            $conn = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            echo "Se conecto correctamente a la base de datos";
            // Configura el modo de error a excepciones
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>
