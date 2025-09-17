<?php
include("src/funciones.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 6</title>
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

    <h2>Ejemplo de POST</h2>
    <form action="index.php" method="post">
        Nombre: <input type="text" name="name"><br>
        Email: <input type="text" name="email"><br>
        <input type="submit" value="Enviar">
    </form>
    <br>
    <?php
        if (isset($_POST["name"]) && isset($_POST["email"])) {
            echo "<b>Nombre:</b> " . $_POST["name"] . "<br>";
            echo "<b>Email:</b> " . $_POST["email"];
        }
    ?>
</body>
</html>
