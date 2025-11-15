<?php
namespace TECWEB\MYAPI\Create;

use TECWEB\MYAPI\DataBase;

class Create extends DataBase {

    public function __construct($db, $user='root', $pass='') {
        parent::__construct($user, $pass, $db);
    }

    public function add($jsonOBJ){
        $this->data = array();
        
        if(is_string($jsonOBJ)) {
            $jsonOBJ = json_decode($jsonOBJ, true);
        }
        
        $nombre = $this->conexion->real_escape_string($jsonOBJ['nombre']);
        $result = $this->conexion->query("SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0");
        
        if($result->num_rows == 0) {
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                    VALUES (
                        '{$this->conexion->real_escape_string($jsonOBJ['nombre'])}',
                        '{$this->conexion->real_escape_string($jsonOBJ['marca'])}',
                        '{$this->conexion->real_escape_string($jsonOBJ['modelo'])}',
                        {$jsonOBJ['precio']},
                        '{$this->conexion->real_escape_string($jsonOBJ['detalles'])}',
                        {$jsonOBJ['unidades']},
                        '{$this->conexion->real_escape_string($jsonOBJ['imagen'])}'
                    )";
            
            if($this->conexion->query($sql)){
                $this->data['status'] = "success";
                $this->data['message'] = "Producto agregado correctamente";
            } else {
                $this->data['status'] = "error";
                $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
        } else {
            $this->data['status'] = "error";
            $this->data['message'] = "ERROR: El producto ya existe";
        }
        
        $result->free();
    }
}
?>