<?php

//Ejercicio1
function esMultiplo5y7($num) {
    if ($num % 5 == 0 && $num % 7 == 0) {
        return "R= El número $num SÍ es múltiplo de 5 y 7.";
    } else {
        return "R= El número $num NO es múltiplo de 5 y 7.";
    }
}

//Ejercicio2
function generarSecuenciaImparParImpar() {
    $matriz = [];
    $iteraciones = 0;
    $condicion = false;

    do {
        $iteraciones++;
        $fila = [];

        for ($i = 0; $i < 3; $i++) {
            $fila[] = rand(100, 999);
        }

        $matriz[] = $fila;

        if ($fila[0] % 2 != 0 && $fila[1] % 2 == 0 && $fila[2] % 2 != 0) {
            $condicion = true;
        }
    } while (!$condicion);

    $totalNumeros = $iteraciones * 3;

    return [
        "matriz" => $matriz,
        "iteraciones" => $iteraciones,
        "totalNumeros" => $totalNumeros
    ];
}

//Ejercicio3
function buscarMultiploWhile($divisor) {
    $num = rand(1, 999);
    while ($num % $divisor != 0) {
        $num = rand(1, 999);
    }
    return $num;
}

function buscarMultiploDoWhile($divisor) {
    do {
        $num = rand(1, 999);
    } while ($num % $divisor != 0);
    return $num;
}
?>

