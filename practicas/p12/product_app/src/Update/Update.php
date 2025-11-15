<?php
namespace TECWEB\MYAPI\Update;

use TECWEB\MYAPI\DataBase;

class Update extends DataBase {
    
    public function __construct($db, $user='root', $pass='') {
        parent::__construct($user, $pass, $db);
    }

    public function edit($jsonOBJ){
        $this->data = array();
        if(is_string($jsonOBJ)) {
            $jsonOBJ = json_decode($jsonOBJ, true);
        }
        
        $sql = "UPDATE productos SET 
                nombre = '{$this->conexion->real_escape_string($jsonOBJ['nombre'])}',
                marca = '{$this->conexion->real_escape_string($jsonOBJ['marca'])}',
                modelo = '{$this->conexion->real_escape_string($jsonOBJ['modelo'])}',
                precio = {$jsonOBJ['precio']},
                detalles = '{$this->conexion->real_escape_string($jsonOBJ['detalles'])}',
                unidades = {$jsonOBJ['unidades']},
                imagen = '{$this->conexion->real_escape_string($jsonOBJ['imagen'])}'
                WHERE id = {$jsonOBJ['id']}";
        
        if($this->conexion->query($sql)){
            $this->data['status'] = "success";
            $this->data['message'] = "Producto actualizado correctamente";
        } else {
            $this->data['status'] = "error";
            $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
        }
    }
}
?>