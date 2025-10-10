<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>

<h2>Ejercicio 1</h2>
<p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
<p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>

<h4>Respuesta:</h4>
<ul class="respuesta">
    <li>$_myvar es válida porque inicia con guión bajo.</li>
    <li>$_7var es válida porque inicia con guión bajo.</li>
    <li>myvar es inválida porque no tiene el signo de dolar ($).</li>
    <li>$myvar es válida porque inicia con una letra.</li>
    <li>$var7 es válida porque inicia con una letra.</li>
    <li>$_element1 es válida porque inicia con guión bajo.</li>
    <li>$house*5 es inválida porque el símbolo * no está permitido.</li>
</ul>

<h2>Ejercicio 2</h2>

<h3>Bloque inicial</h3>
<p>$a = ManejadorSQL</p>
<p>$b = MySQL</p>
<p>$c = ManejadorSQL</p>

<h3>Segundo bloque</h3>
<p>$a = PHP server</p>
<p>$b = PHP server</p>
<p>$c = PHP server</p>

<h3>Explicación</h3>
<p>En el primer bloque, $c es referencia de $a, por lo que si cambia $a también cambia $c, pero $b era independiente con valor 'MySQL'.</p>
<p>En el segundo bloque, al hacer $b = &amp;$a, $b también se convierte en referencia de $a. Entonces las tres variables ($a, $b y $c) comparten el mismo valor: 'PHP server'.</p>

<h2>Ejercicio 3</h2>

<h3>Después de $a = 'PHP5' y $z[] = &amp;$a</h3>
<p>$a = PHP5</p>
<p>$z[0] = PHP5</p>
<p>Tipo de $a: string</p>
<p>Tipo de $z[0]: string</p>
<hr>

<h3>Después de $b = '5a version de PHP'</h3>
<p>$b = 5a version de PHP</p>
<p>Tipo de $b: string</p>
<hr>

<h3>Después de $c = $b * 10</h3>
<p>$c = 50</p>
<p>Tipo de $c: integer</p>
<hr>

<h3>Después de $a .= $b</h3>
<p>$a = PHP55a version de PHP</p>
<p>$z[0] = PHP55a version de PHP</p>
<p>Tipo de $a: string</p>
<p>Tipo de $z[0]: string</p>
<hr>

<h3>Después de $b *= $c</h3>
<p>$b = 250</p>
<p>Tipo de $b: integer</p>
<hr>

<h3>Después de $z[0] = 'MySQL'</h3>
<p>$a = MySQL</p>
<p>$z[0] = MySQL</p>
<p>Tipo de $a: string</p>
<p>Tipo de $z[0]: string</p>
<hr>

<h2>Ejercicio 4</h2>

<h3>Usando $GLOBALS</h3>
<p>$a = MySQL</p>
<p>$b = 250</p>
<p>$c = 50</p>
<p>$z[0] = MySQL</p>

<h3>Usando global</h3>
<p>$a = MySQL</p>
<p>$b = 250</p>
<p>$c = 50</p>
<p>$z[0] = MySQL</p>

<h2>Ejercicio 5</h2>
<p>$a = 9E3</p>
<p>$b = 7</p>
<p>$c = 9000</p>

<h2>Ejercicio 6</h2>

<h3>Valores con var_dump()</h3>
<pre>
bool(false)
bool(true)
bool(false)
bool(true)
bool(false)
bool(true)
</pre>

<h3>Valores de $c y $e con echo</h3>
<p>$c = 0</p>
<p>$e = 0</p>

<h2>Ejercicio 7</h2>

<h3>a) Versión de Apache y PHP</h3>
<p>Servidor: Apache/2.4.52 (Win64) OpenSSL/1.1.1m PHP/8.1.2</p>
<p>Versión de PHP: 8.1.2</p>

<h3>b) Nombre del sistema operativo (servidor)</h3>
<p>Windows NT</p>

<h3>c) Idioma del navegador (cliente)</h3>
<p>es-MX,es;q=0.9,en;q=0.8</p>

<p>
    <a href="https://validator.w3.org/nu/?doc=https%3A%2F%2Ftu-servidor.com%2Fpractica3.html">
        <img src="https://www.w3.org/Icons/valid-html401" alt="Valid HTML5" height="31" width="88">
    </a>
</p>

</body>
</html>


