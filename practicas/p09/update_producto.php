<?php
    $message = '';
    $message_type = 'danger'; // 'danger' para error, 'success' para éxito

    // Verificar que la solicitud sea por POST y que se haya enviado un ID
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        
        /** SE CREA EL OBJETO DE CONEXIÓN */
        @$link = new mysqli('localhost', 'root', '', 'marketzone');

        /** GESTIONAR EL ERROR DE CONEXIÓN */
        if ($link->connect_errno) {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
        }

        /** OBTENER Y SANITIZAR LOS DATOS DEL FORMULARIO */
        $id = $_POST['id'];
        $nombre = $_POST['nombre'] ?? '';
        $marca = $_POST['marca'] ?? '';
        $modelo = $_POST['modelo'] ?? '';
        $precio = $_POST['precio'] ?? 0.0;
        $detalles = $_POST['detalles'] ?? '';
        $unidades = $_POST['unidades'] ?? 0;
        
        // Se mantiene la imagen actual si no se sube una nueva
        $imagen_path = $_POST['imagen_actual'] ?? 'images/productos/default.png';

        // --- MANEJO DE LA NUEVA IMAGEN (SI EXISTE) ---
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $file_tmp_path = $_FILES['imagen']['tmp_name'];
            $file_name = $_FILES['imagen']['name'];
            
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $new_file_name = md5(time() . $file_name) . '.' . $file_extension;
            $dest_path = 'images/productos/' . $new_file_name;

            if(move_uploaded_file($file_tmp_path, $dest_path)) {
                $imagen_path = $dest_path; // Si se sube una nueva, se actualiza la ruta
            } else {
                $message = "Error al mover el nuevo archivo de imagen.";
            }
        }
        
        // Preparar la consulta de actualización
        $sql = "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, detalles = ?, unidades = ?, imagen = ? WHERE id = ?";
        
        if ($stmt = $link->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("sssdsssi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen_path, $id);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                $message = "Registro actualizado exitosamente.";
                $message_type = 'success';
            } else {
                $message = "ERROR: No se pudo ejecutar la actualización. " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "ERROR: No se pudo preparar la consulta. " . $link->error;
        }

        /** CERRAR LA CONEXIÓN */
        $link->close();

    } else {
        $message = "Acceso no permitido o ID de producto no especificado.";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Actualización</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container { margin-top: 50px; }
        .links a { margin-right: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="alert alert-<?php echo $message_type; ?>" role="alert">
            <?php echo $message; ?>
        </div>
        <div class="links">
            <a href="get_productos_vigentes_v2.php" class="btn btn-primary">Ver Productos Vigentes</a>
            <a href="get_productos_xhtml_v2.php" class="btn btn-secondary">Ver Productos por Tope</a>
        </div>
    </div>
</body>
</html>