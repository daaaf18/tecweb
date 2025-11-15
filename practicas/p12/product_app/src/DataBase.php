<?php
namespace TECWEB\MYAPI;

// Marcar la clase como abstracta
abstract class DataBase {
    
    // ropiedades protegidas
    protected $conexion;
    protected $data = null; // Propiedad movida de Products

    public function __construct($user, $pass, $db){
        $this->data = array(); // Inicializamos
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );

        if(!$this->conexion) {
        die('¡Base de datos NO conectada! Error: ' . mysqli_connect_error());
    }
        
        // Aseguración de la codificación
        $this->conexion->set_charset("utf8");
    }

    // Método movido de Products (como en el UML)
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
    
    // Cierra la conexión automáticamente al final
    public function __destruct() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>