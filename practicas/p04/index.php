<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 3</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-color: #f9f9f9;
        }
        h2 {
            color: #2c3e50;
            margin-top: 30px;
        }
        h3 {
            color: #34495e;
        }
        h4 {
            color: #2c3e50;
        }
        ul {
            list-style-type: disc;
            padding-left: 40px;
        }
        p {
            margin-bottom: 10px;
        }
        .respuesta li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<h2>Ejercicio 1</h2>
<p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
<p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
<?php
    $_myvar = null;
    $_7var = null;
    $myvar = null;
    $var7 = null;
    $_element1 = null;


    echo '<h4>Respuesta:</h4>';   
    echo '<ul class="respuesta">';
    echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
    echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
    echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
    echo '<li>$myvar es válida porque inicia con una letra.</li>';
    echo '<li>$var7 es válida porque inicia con una letra.</li>';
    echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
    echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
    echo '</ul>';
?>

<h2>Ejercicio 2</h2>
<?php
$a = "ManejadorSQL";
$b = 'MySQL';
$c = &$a;

echo "<h3>Bloque inicial</h3>";
echo "\$a = $a <br>";
echo "\$b = $b <br>";
echo "\$c = $c <br>";

$a = "PHP server";
$b = &$a;

echo "<h3>Segundo bloque</h3>";
echo "\$a = $a <br>";
echo "\$b = $b <br>";
echo "\$c = $c <br>";

echo "<h3>Explicación</h3>";
echo "En el primer bloque, \$c es referencia de \$a, por lo que si cambia \$a también cambia \$c, pero \$b era independiente con valor 'MySQL'.<br>";
echo "En el segundo bloque, al hacer \$b = &\$a, \$b también se convierte en referencia de \$a. Entonces las tres variables (\$a, \$b y \$c) comparten el mismo valor: 'PHP server'.<br>";

unset($a, $b, $c);
?>

<h2>Ejercicio 3</h2>
<?php
$a = "PHP5";
$z = array();
$z[] = &$a;

echo "<h3>Después de \$a = 'PHP5' y \$z[] = &\$a</h3>";
echo "\$a = $a <br>";
echo "\$z[0] = {$z[0]} <br>";
echo "Tipo de \$a: " . gettype($a) . "<br>";
echo "Tipo de \$z[0]: " . gettype($z[0]) . "<br><hr>";

$b = "5a version de PHP";
echo "<h3>Después de \$b = '5a version de PHP'</h3>";
echo "\$b = $b <br>";
echo "Tipo de \$b: " . gettype($b) . "<br><hr>";

$c = (int)$b * 10; 
echo "<h3>Después de \$c = \$b * 10</h3>";
echo "\$c = $c <br>";
echo "Tipo de \$c: " . gettype($c) . "<br><hr>";

$a .= $b;
echo "<h3>Después de \$a .= \$b</h3>";
echo "\$a = $a <br>";
echo "\$z[0] = {$z[0]} <br>";
echo "Tipo de \$a: " . gettype($a) . "<br>";
echo "Tipo de \$z[0]: " . gettype($z[0]) . "<br><hr>";

$b = (int)$b; 
$b *= $c;
echo "<h3>Después de \$b *= \$c</h3>";
echo "\$b = $b <br>";
echo "Tipo de \$b: " . gettype($b) . "<br><hr>";

$z[0] = "MySQL";
echo "<h3>Después de \$z[0] = 'MySQL'</h3>";
echo "\$a = $a <br>";
echo "\$z[0] = {$z[0]} <br>";
echo "Tipo de \$a: " . gettype($a) . "<br>";
echo "Tipo de \$z[0]: " . gettype($z[0]) . "<br><hr>";

unset($a, $b, $c, $z);
?>

<h2>Ejercicio 4</h2>
<?php
$a = "PHP5";
$z = array();
$z[] = &$a;
$b = "5a version de PHP";
$c = (int)$b * 10;
$a .= $b;
$b = (int)$b;
$b *= $c;
$z[0] = "MySQL";

function mostrarConGlobals() {
    echo "<h3>Usando \$GLOBALS</h3>";
    echo "\$a = " . $GLOBALS['a'] . "<br>";
    echo "\$b = " . $GLOBALS['b'] . "<br>";
    echo "\$c = " . $GLOBALS['c'] . "<br>";
    echo "\$z[0] = " . $GLOBALS['z'][0] . "<br>";
}

function mostrarConGlobal() {
    global $a, $b, $c, $z;
    echo "<h3>Usando global</h3>";
    echo "\$a = $a <br>";
    echo "\$b = $b <br>";
    echo "\$c = $c <br>";
    echo "\$z[0] = {$z[0]} <br>";
}

mostrarConGlobals();
mostrarConGlobal();

unset($a, $b, $c, $z);
?>


<h2>Ejercicio 5</h2>
<?php
$a = "7 personas";
$b = (int) $a;
$a = "9E3";
$c = (float) $a; 

echo "\$a = $a <br>";
echo "\$b = $b <br>";
echo "\$c = $c <br>";

unset($a, $b, $c);
?>

<h2>Ejercicio 6</h2>
<?php
$a = (bool) "0";
$b = (bool) "TRUE";
$c = FALSE;
$d = ($a OR $b);
$e = ($a AND $c);
$f = ($a XOR $b);

echo "<h3>Valores con var_dump()</h3>";
var_dump($a);
var_dump($b);
var_dump($c);
var_dump($d);
var_dump($e);
var_dump($f);

echo "<h3>Valores de \$c y \$e con echo</h3>";
echo "\$c = " . (int)$c . "<br>";
echo "\$e = " . (int)$e . "<br>";

unset($a, $b, $c, $d, $e, $f);
?>

<h2>Ejercicio 7</h2>
<?php
echo "<h3>a) Versión de Apache y PHP</h3>";
if (isset($_SERVER['SERVER_SOFTWARE'])) {
    echo "Servidor: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
}
echo "Versión de PHP: " . phpversion() . "<br>";

echo "<h3>b) Nombre del sistema operativo (servidor)</h3>";
echo php_uname('s') . "<br>";

echo "<h3>c) Idioma del navegador (cliente)</h3>";
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    echo $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "<br>";
}
?>

</body>
</html>


