<?php
    $rows = array();
    if(isset($_GET['tope'])) {
        $tope = $_GET['tope'];

        if (!empty($tope) && is_numeric($tope)) {
            /** SE CREA EL OBJETO DE CONEXIÓN */
            @$link = new mysqli('localhost', 'root', '', 'marketzone');

            /** GESTIONAR EL ERROR DE CONEXIÓN */
            if ($link->connect_errno) {
                die('Falló la conexión: '.$link->connect_error.'<br/>');
            }

            /** Crear la consulta para seleccionar productos */
            $sql = "SELECT * FROM productos WHERE unidades <= {$tope}";

            /** Ejecutar la consulta */
            if ( $result = $link->query($sql) ) {
                /** Se extraen todas las filas del resultado en un arreglo asociativo */
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                /** Liberar la memoria asociada al resultado */
                $result->free();
            }

            $link->close();
        } else {

            $error = 'El parámetro "tope" debe ser un número válido.';
        }
    } else {

        $error = 'Parámetro "tope" no detectado...';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos por Tope de Unidades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h3>Productos<?php echo isset($tope) ? $tope : ''; ?></h3>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <div class="alert alert-warning" role="alert">
            <?php
                if (isset($error)) {
                    echo $error;
                } else {
                    echo 'No se encontraron productos con esa cantidad de unidades o menos.';
                }
            ?>
        </div>
    <?php endif; ?>
</body>
</html>