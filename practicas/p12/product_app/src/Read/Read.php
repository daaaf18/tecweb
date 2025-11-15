<?php
namespace TECWEB\MYAPI\Read;

use TECWEB\MYAPI\DataBase;

class Read extends DataBase {
    
    public function __construct($db, $user='root', $pass='12345678a') {
        parent::__construct($user, $pass, $db);
    }

    public function list(){
        $this->data = array();
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
    }

    public function search($search){
        $this->data = array();
        $search = $this->conexion->real_escape_string($search);
        $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)) {
                foreach($rows as $num => $row) {
                    foreach($row as $key => $value) {
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
    }

    public function single($id){
        $this->data = array();
        $id = $this->conexion->real_escape_string($id);
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}")) {
            $row = $result->fetch_assoc();
            if(!is_null($row)) {
                foreach($row as $key => $value) {
                    $this->data[$key] = $value;
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
    }

    public function singleByName($nombre){
        $this->data = array();
        $nombre = $this->conexion->real_escape_string($nombre);
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0")) {
            if($result->num_rows > 0) {
                $this->data = array('existe' => true);
            } else {
                $this->data = array('existe' => false);
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($this->conexion));
        }
    }
}
?>