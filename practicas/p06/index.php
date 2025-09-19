<?php
include("src/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 6</title>
    <style>
body {
    font-family: 'Poppins', Arial, sans-serif;
    background-color: #f0f8ff;
    color: #333;
    padding: 20px;
}
</style>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Comprobar si un número es múltiplo de 5 y 7 (usar GET en la URL)</p>
    <p>Ejemplo: <b>http://localhost/p06/index.php?numero=35</b></p>
    <?php
        if (isset($_GET['numero'])) {
            $num = (int) $_GET['numero'];
            echo "<h3>" . esMultiplo5y7($num) . "</h3>";
        } else {
            echo "<p>No se ha proporcionado número en la URL.</p>";
        }
    ?>

    <hr>

    <h2>Ejercicio 2</h2>
    <p>Generar números aleatorios hasta obtener secuencia <b>impar-par-impar</b>:</p>
    <?php
        $resultado = generarSecuenciaImparParImpar();

        echo "<table border='1' cellpadding='5'>";
        foreach ($resultado["matriz"] as $fila) {
            echo "<tr>";
            foreach ($fila as $num) {
                echo "<td>$num</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<p><b>{$resultado['totalNumeros']}</b> números obtenidos en 
              <b>{$resultado['iteraciones']}</b> iteraciones.</p>";
    ?>

    <hr>

<h2>Ejercicio 3</h2>
<p>Buscar el primer número aleatorio que sea múltiplo de un número dado (GET).</p>
<p>Ejemplo: <b>http://localhost/tecweb/practicas/p06/index.php?divisor=7</b></p>

<?php
if (isset($_GET['divisor'])) {
    $divisor = (int) $_GET['divisor'];

    echo "<p><b>Con WHILE:</b> " . buscarMultiploWhile($divisor) . "</p>";
    echo "<p><b>Con DO-WHILE:</b> " . buscarMultiploDoWhile($divisor) . "</p>";

} else {
    echo "<p>No se proporcionó divisor. Agrega en la URL: ?divisor=7</p>";
}
?>

<hr>

<h2>Ejercicio 4</h2>
<p>Arreglo de letras de la 'a' a la 'z' con índices ASCII 97 a 122:</p>

<?php
echo generarTablaASCII();
?>

<hr>

<h2>Ejercicio 5</h2>
<p>Formulario para verificar sexo y edad:</p>

<form action="respuesta.php" method="post">
    <label for="edad">Edad:</label>
    <input type="number" name="edad" id="edad" required><br><br>

    <label for="sexo">Sexo:</label>
    <select name="sexo" id="sexo" required>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
    </select><br><br>

    <input type="submit" value="Enviar">
</form>

<hr>

<h2>Ejercicio 6</h2>
<p>Consulta el parque vehicular:</p>

<form action="respuesta.php" method="post">
    <label for="matricula">Consultar por matrícula:</label>
    <input type="text" name="matricula" id="matricula" placeholder="Ej: UBN6338">
    <input type="submit" name="consultar" value="Buscar">
    <input type="submit" name="consultar" value="Mostrar todos">
</form>

<br>

<?php
if (isset($_POST["consultar"])) {
    $vehiculos = obtenerParqueVehicular();

    if ($_POST["consultar"] === "Buscar" && !empty($_POST["matricula"])) {
        $matricula = strtoupper($_POST["matricula"]);
        if (isset($vehiculos[$matricula])) {
            echo "<pre>";
            print_r([$matricula => $vehiculos[$matricula]]);
            echo "</pre>";
        } else {
            echo "<p>No se encontró vehículo con matrícula $matricula</p>";
        }
    } elseif ($_POST["consultar"] === "Mostrar todos") {
        echo "<pre>";
        print_r($vehiculos);
        echo "</pre>";
    }
}
?>
</body>
</html>
