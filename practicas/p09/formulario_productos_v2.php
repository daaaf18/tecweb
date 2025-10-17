<?php
    // Por defecto, es un formulario de registro
    $isUpdate = false;
    $id_producto = '';
    $nombre_producto = '';
    $marca = '';
    $modelo = '';
    $precio = '';
    $detalles = '';
    $unidades = '';
    $imagen = '';

    // Si se reciben datos por POST, es una actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $isUpdate = true;
        
        // Asignar los valores recibidos a las variables
        $id_producto = htmlspecialchars($_POST['id']);
        $nombre_producto = htmlspecialchars($_POST['nombre']);
        $marca = htmlspecialchars($_POST['marca']);
        $modelo = htmlspecialchars($_POST['modelo']);
        $precio = htmlspecialchars($_POST['precio']);
        $detalles = htmlspecialchars($_POST['detalles']);
        $unidades = htmlspecialchars($_POST['unidades']);
        $imagen = htmlspecialchars($_POST['imagen']);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isUpdate ? 'Modificar Producto' : 'Registro de Nuevo Producto'; ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #555; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-group textarea { resize: vertical; height: 100px; }
        .btn { display: block; width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .btn:hover { background-color: #218838; }
        .current-image { margin-top: 10px; }
    </style>
</head>
<body>

    <div class="container">
        <h2><?php echo $isUpdate ? 'Modificar Producto' : 'Registrar Nuevo Producto'; ?></h2>

        <div id="error-messages"></div>

        <form id="product-form" action="<?php echo $isUpdate ? 'update_producto.php' : 'set_producto_v2.php'; ?>" method="POST" enctype="multipart/form-data">
            
            <?php if ($isUpdate): ?>
                <input type="hidden" name="id" value="<?php echo $id_producto; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="nombre_producto">Nombre del Producto:</label>
                <input type="text" id="nombre_producto" name="nombre" value="<?php echo $nombre_producto; ?>" maxlength="100">
            </div>
            
            <div class="form-group">
                <label for="marca">Marca:</label>
                <select id="marca" name="marca">
                    <option value="" disabled>-- Seleccione una marca --</option>
                    <option value="Zara" <?php if ($marca === 'Zara') echo 'selected'; ?>>Zara</option>
                    <option value="Stradivarius" <?php if ($marca === 'Stradivarius') echo 'selected'; ?>>Stradivarius</option>
                    <option value="H&M" <?php if ($marca === 'H&M') echo 'selected'; ?>>H&M</option>
                    <option value="Levis" <?php if ($marca === 'Levis') echo 'selected'; ?>>Levi´s</option>
                    <option value="Sanrio" <?php if ($marca === 'Sanrio') echo 'selected'; ?>>Sanrio</option>
                    <option value="Pull&Bear" <?php if ($marca === 'Pull&Bear') echo 'selected'; ?>>Pull&Bear</option>
                    <option value="Vans" <?php if ($marca === 'Vans') echo 'selected'; ?>>Vans</option>
                    <option value="Youngla" <?php if ($marca === 'Youngla') echo 'selected'; ?>>YoungLA</option>
                </select>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" id="modelo" name="modelo" value="<?php echo $modelo; ?>" maxlength="25">
            </div>

            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $precio; ?>" min="100.00" step="0.01">
            </div>

            <div class="form-group">
                <label for="detalles">Detalles:</label>
                <textarea id="detalles" name="detalles" maxlength="250"><?php echo $detalles; ?></textarea>
            </div>

            <div class="form-group">
                <label for="unidades">Unidades Disponibles:</label>
                <input type="number" id="unidades" name="unidades" value="<?php echo $unidades; ?>" min="0">
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del Producto (opcional, para cambiar la actual):</label>
                <?php if ($isUpdate && !empty($imagen)): ?>
                    <div class="current-image">
                        <p>Imagen actual:</p>
                        <img src="<?php echo $imagen; ?>" alt="Imagen actual del producto" style="width: 100px;"/>
                    </div>
                <?php endif; ?>
                <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png, image/gif">
            </div>

            <input type="hidden" name="imagen_actual" value="<?php echo $imagen; ?>">

            <button type="submit" class="btn"><?php echo $isUpdate ? 'Actualizar Producto' : 'Registrar Producto'; ?></button>
        </form>
    </div>
    </body>
</html>