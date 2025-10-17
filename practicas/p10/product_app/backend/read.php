<?php
    include_once __DIR__.'/database.php';

    header('Content-Type: application/json');
    $data = array();

    // CASO 1: BÚSQUEDA POR ID
    if( isset($_POST['id']) && !empty(trim($_POST['id'])) ) {
        $id = trim($_POST['id']);
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ? AND eliminado = 0");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $data[] = $result->fetch_assoc();
            }
        }
        $stmt->close();
    } 
    // CASO 2: BÚSQUEDA POR TEXTO
    else if( isset($_POST['search']) && !empty(trim($_POST['search'])) ) {
        $search = trim($_POST['search']);
        $searchTerm = "%{$search}%";
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE (nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) AND eliminado = 0");
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $stmt->close();
    }
    // CASO 3: DEVOLVER TODOS LOS PRODUCTOS ACTIVOS
    else {
        $query = "SELECT * FROM productos WHERE eliminado = 0";
        if ( $result = $conexion->query($query) ) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }
    }
    
    $conexion->close();
    
    echo json_encode($data, JSON_PRETTY_PRINT);
?>