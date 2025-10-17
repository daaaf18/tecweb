<?php
    include_once __DIR__.'/database.php';

    // Establecer la cabecera para devolver una respuesta JSON
    header('Content-Type: application/json');
    $response = array();

    // Obtener el JSON enviado por el cliente
    $productoJson = file_get_contents('php://input');

    if (!empty($productoJson)) {
        $jsonOBJ = json_decode($productoJson);

        // Asignar los datos a variables para mayor claridad
        $nombre = $conexion->real_escape_string($jsonOBJ->nombre);
        $marca  = $conexion->real_escape_string($jsonOBJ->marca);
        $modelo = $conexion->real_escape_string($jsonOBJ->modelo);
        // ... (asigna el resto de variables: precio, unidades, etc.)
        $precio   = (float)$jsonOBJ->precio;
        $detalles = $conexion->real_escape_string($jsonOBJ->detalles);
        $unidades = (int)$jsonOBJ->unidades;
        $imagen   = $conexion->real_escape_string($jsonOBJ->imagen);

        // 1. VALIDAR SI EL PRODUCTO YA EXISTE (y no está eliminado)
        $check_stmt = $conexion->prepare(
            "SELECT id FROM productos WHERE ((nombre = ? AND marca = ?) OR (marca = ? AND modelo = ?)) AND eliminado = 0"
        );
        $check_stmt->bind_param("ssss", $nombre, $marca, $marca, $modelo);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            // El producto ya existe y está activo, se devuelve un error
            $response['status'] = 'error';
            $response['message'] = 'Error: Ya existe un producto activo con ese nombre/marca o marca/modelo.';
        } else {
            // 2. Si no existe, se procede con la INSERCIÓN
            $insert_stmt = $conexion->prepare(
                "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) VALUES (?, ?, ?, ?, ?, ?, ?, 0)"
            );
            $insert_stmt->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
            
            if ($insert_stmt->execute()) {
                $response['status'] = 'success';
                $response['message'] = '¡Producto agregado exitosamente!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error en la base de datos al agregar el producto: ' . $conexion->error;
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No se recibieron datos.';
    }

    $conexion->close();

    // 3. Devolver la respuesta final al cliente
    echo json_encode($response, JSON_PRETTY_PRINT);
?>