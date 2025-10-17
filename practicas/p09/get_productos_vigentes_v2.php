<?php
    $rows = array();
    @$link = new mysqli('localhost', 'root', '', 'marketzone');
    if ($link->connect_errno) {
        die('Falló la conexión: '.$link->connect_error.'<br/>');
    }
    $sql = "SELECT * FROM productos WHERE eliminado = 0";
    if ( $result = $link->query($sql) ) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    }
    $link->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos Vigentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <h3>Productos Vigentes</h3>
    <br/>
    <?php if (!empty($rows)) : ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Unidades</th>
                    <th scope="col">Detalles</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Modificar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['marca']; ?></td>
                        <td><?php echo $row['modelo']; ?></td>
                        <td>$<?php echo number_format($row['precio'], 2); ?></td>
                        <td><?php echo $row['unidades']; ?></td>
                        <td><?php echo utf8_encode($row['detalles']); ?></td>
                        <td><img src="<?php echo $row['imagen']; ?>" alt="Imagen del producto" style="width: 100px;"/></td>
                        <td>
                            <button class="btn btn-warning" onclick='sendToForm(<?php echo json_encode($row); ?>)'>Modificar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">No se encontraron productos vigentes.</div>
    <?php endif; ?>

    <script>
        function sendToForm(producto) {
            // Crea un formulario dinámico en la memoria
            var form = document.createElement("form");
            form.method = 'POST';
            form.action = 'formulario_productos_v2.php';
            
            // Crea un input oculto por cada dato del producto
            for (var key in producto) {
                if (producto.hasOwnProperty(key)) {
                    var input = document.createElement("input");
                    input.type = 'hidden';
                    input.name = key;
                    input.value = producto[key];
                    form.appendChild(input);
                }
            }

            // Añade el formulario al cuerpo del documento y lo envía
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>