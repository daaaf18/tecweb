<?php
namespace TECWEB\MYAPI;

use TECWEB\MYAPI\DataBase as DataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends DataBase {
    private $data = NULL;
    
    // El constructor usa los parámetros opcionales e inicializa la conexión padre
    public function __construct($db, $user='root', $pass='12345678a') {
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }

    // Método para listar (list)
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
        $this->conexion->close();
    }

    // Método para buscar (search)
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
        $this->conexion->close();
    }

    // Método para un solo producto (single)
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
        $this->conexion->close();
    }

    // Método para buscar por nombre (singleByName)
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
        $this->conexion->close();
    }

    // Método para agregar (add)
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
        $this->conexion->close();
    }

    // Método para editar (edit)
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
        
        $this->conexion->close();
    }

    // Método para eliminar (delete)
    public function delete($id){
        $this->data = array();
        $id = $this->conexion->real_escape_string($id);
        
        // Nota: Esta es una eliminación lógica (soft delete)
        $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";
        
        if($this->conexion->query($sql)){
            $this->data['status'] = "success";
            $this->data['message'] = "Producto eliminado correctamente";
        } else {
            $this->data['status'] = "error";
            $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
        }
        
        $this->conexion->close();
    }

    // Método para obtener datos como JSON (getData)
    public function getData() {
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>