<?php
include("src/funciones.php");

// Ejercicio 5
if (isset($_POST["edad"]) && isset($_POST["sexo"])) {
    $edad = (int) $_POST["edad"];
    $sexo = $_POST["sexo"];
    $mensajeEj5 = validarEdadSexo($edad, $sexo);
} else {
    $mensajeEj5 = null; // No se enviaron datos
}

// Ejercicio 6
$vehiculos = obtenerParqueVehicular();
$mensajeEj6 = null;
$arrayEj6 = null;

if (isset($_POST["consultar"])) {
    if ($_POST["consultar"] === "Buscar" && !empty($_POST["matricula"])) {
        $matricula = strtoupper($_POST["matricula"]);
        if (isset($vehiculos[$matricula])) {
            $arrayEj6 = $vehiculos[$matricula];
        } else {
            $mensajeEj6 = "No se encontró vehículo con matrícula <b>$matricula</b>";
        }
    } elseif ($_POST["consultar"] === "Mostrar todos") {
        $arrayEj6 = $vehiculos;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado Ejercicios 5 y 6</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            padding: 20px;
        }
        pre {
            background-color: #e7f3ff;
            padding: 10px;
            border-left: 4px solid #2a7ae2;
            overflow-x: auto;
        }
        h2 { color: #2a7ae2; }
        p { background-color: #e7f3ff; padding: 8px 12px; border-left: 4px solid #2a7ae2; border-radius: 4px; }
    </style>
</head>
<body>

    <?php if ($mensajeEj5 !== null): ?>
        <h2>Resultado del Ejercicio 5</h2>
        <p><b><?php echo $mensajeEj5; ?></b></p>
    <?php endif; ?>

    <?php if ($mensajeEj6 !== null): ?>
        <h2>Resultado del Ejercicio 6</h2>
        <p><?php echo $mensajeEj6; ?></p>
    <?php endif; ?>

    <?php if ($arrayEj6 !== null): ?>
        <h2>Resultado del Ejercicio 6</h2>
        <pre><?php print_r($arrayEj6); ?></pre>
    <?php endif; ?>

    <br>
    <a href="index.php">← Volver al formulario</a>
</body>
</html>


