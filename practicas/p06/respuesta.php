<?php
include("src/funciones.php");

if (isset($_POST["edad"]) && isset($_POST["sexo"])) {
    $edad = (int) $_POST["edad"];
    $sexo = $_POST["sexo"];
    $mensaje = validarEdadSexo($edad, $sexo);
} else {
    $mensaje = "No se enviaron datos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Ejercicio 5</title>
</head>
<body>
    <h2>Resultado del Ejercicio 5</h2>
    <p><b><?php echo $mensaje; ?></b></p>
    <a href="index.php">Volver al formulario</a>
</body>
</html>
