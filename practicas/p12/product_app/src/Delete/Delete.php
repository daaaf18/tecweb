<?php
namespace TECWEB\MYAPI\Delete;

use TECWEB\MYAPI\DataBase;

class Delete extends DataBase {
    
    public function __construct($db, $user='root', $pass='12345678a') {
        parent::__construct($user, $pass, $db);
    }

    public function delete($id){
        $this->data = array();
        $id = $this->conexion->real_escape_string($id);
        $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";
        
        if($this->conexion->query($sql)){
            $this->data['status'] = "success";
            $this->data['message'] = "Producto eliminado correctamente";
        } else {
            $this->data['status'] = "error";
            $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
        }
    }
}
?>