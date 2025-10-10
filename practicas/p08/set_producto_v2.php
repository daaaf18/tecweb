<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = trim($_POST['nombre_producto']);
    $marca  = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $precio = $_POST['precio'];
    $detalles = trim($_POST['detalles']);
    $unidades = $_POST['unidades'];

    //Conectar a la Base de datos
    @$link = new mysqli('localhost', 'root', '', 'marketzone'); 

    if ($link->connect_errno) {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
    }

    //Validar que el prooducto no exista
    $sql_check = "SELECT COUNT(*) as count FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?";
    if ($stmt_check = $link->prepare($sql_check)) {
        $stmt_check->bind_param('sss', $nombre, $marca, $modelo);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row = $result_check->fetch_assoc();
        
        // Si el conteo es mayor a 0, el producto ya existe
        if ($row['count'] > 0) {
            $error_message = "Error: Ya existe un producto con el mismo Nombre, Marca y Modelo.";
        }
        $stmt_check->close();
    } else {
        $error_message = "Error al preparar la consulta de verificación.";
    }

    if (!isset($error_message)) {

        $imagen_nombre = 'img/default.png'; 
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
            $directorio_destino = "img/";
            if (!file_exists($directorio_destino)) {
                mkdir($directorio_destino, 0777, true);
            }
            $nombre_unico = uniqid() . '-' . basename($_FILES["imagen"]["name"]);
            $ruta_destino = $directorio_destino . $nombre_unico;

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_destino)) {
                $imagen_nombre = $ruta_destino;
            } else {
                $error_message = "Hubo un error al mover el archivo de imagen.";
            }
        }

        if (!isset($error_message)) {
            $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            if ($stmt_insert = $link->prepare($sql_insert)) {
                $stmt_insert->bind_param('sssdiss', $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen_nombre);
                
                if ($stmt_insert->execute()) {
                    $success_message = "<h2>¡Producto registrado con éxito!</h2>";
                    $success_message .= "<h3>Resumen de los datos insertados:</h3>";
                    $success_message .= "<ul>";
                    $success_message .= "<li><strong>ID Asignado:</strong> " . $link->insert_id . "</li>";
                    $success_message .= "<li><strong>Nombre:</strong> " . htmlspecialchars($nombre) . "</li>";
                    $success_message .= "<li><strong>Marca:</strong> " . htmlspecialchars($marca) . "</li>";
                    $success_message .= "<li><strong>Modelo:</strong> " . htmlspecialchars($modelo) . "</li>";
                    $success_message .= "<li><strong>Precio:</strong> $" . number_format($precio, 2) . "</li>";
                    $success_message .= "<li><strong>Detalles:</strong> " . htmlspecialchars($detalles) . "</li>";
                    $success_message .= "<li><strong>Unidades:</strong> " . $unidades . "</li>";
                    $success_message .= "<li><strong>Ruta Imagen:</strong> " . htmlspecialchars($imagen_nombre) . "</li>";
                    $success_message .= "</ul>";
                } else {
                    $error_message = 'El Producto no pudo ser insertado. Error: ' . $stmt_insert->error;
                }
                $stmt_insert->close();
            } else {
                $error_message = 'Error al preparar la consulta de inserción: ' . $link->error;
            }
        }
    }

    $link->close();

} else {
    $error_message = "Acceso denegado. Por favor, utiliza el formulario para registrar productos.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Respuesta del Servidor</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 40px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { border-left: 5px solid #28a745; background-color: #e9f7ef; padding: 15px; }
        .error { border-left: 5px solid #dc3545; background-color: #f8d7da; color: #721c24; padding: 15px; }
        h2, h3 { color: #333; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 8px; }
        a { color: #007bff; text-decoration: none; display: inline-block; margin-top: 20px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($success_message)): ?>
            <div class="success">
                <?php echo $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="error">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
        <a href="formulario_productos.html">← Volver al formulario</a>
    </div>
</body>
</html>