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

//Ejercicio4 
function generarTablaASCII() {
    $arreglo = [];

    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }

    $tabla = "<table border='1' cellpadding='5'>";
    $tabla .= "<tr><th>Índice (ASCII)</th><th>Letra</th></tr>";
    foreach ($arreglo as $key => $value) {
        $tabla .= "<tr><td>$key</td><td>$value</td></tr>";
    }
    $tabla .= "</table>";

    return $tabla;
}

//Ejercicio5
function validarEdadSexo($edad, $sexo) {
    $sexo = strtolower($sexo); // asegurar minúsculas
    if ($sexo === "femenino" && $edad >= 18 && $edad <= 35) {
        return "Bienvenida, usted está en el rango de edad permitido.";
    } else {
        return "Lo sentimos, no cumple con los requisitos.";
    }
}

//Ejercicio6
function obtenerParqueVehicular() {
    $vehiculos = [
        "UBN6338" => [
            "Auto" => ["marca" => "HONDA", "modelo" => 2020, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Alfonzo Esparza", "ciudad" => "Puebla, Pue.", "direccion" => "C.U., Jardines de San Manuel"]
        ],
        "UBN6339" => [
            "Auto" => ["marca" => "MAZDA", "modelo" => 2019, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Ma. del Consuelo Molina", "ciudad" => "Puebla, Pue.", "direccion" => "97 oriente"]
        ],
        "XYZ1234" => [
            "Auto" => ["marca" => "TOYOTA", "modelo" => 2021, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "Luis Pérez", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Reforma 45"]
        ],
        "ABC5678" => [
            "Auto" => ["marca" => "NISSAN", "modelo" => 2020, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Ana López", "ciudad" => "Puebla, Pue.", "direccion" => "Calle 10 #5"]
        ],
        "DEF9012" => [
            "Auto" => ["marca" => "FORD", "modelo" => 2018, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Carlos Sánchez", "ciudad" => "Puebla, Pue.", "direccion" => "Boulevard Atlixco 123"]
        ],
        "GHI3456" => [
            "Auto" => ["marca" => "CHEVROLET", "modelo" => 2019, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Marta Ramírez", "ciudad" => "Puebla, Pue.", "direccion" => "Calle 22 #7"]
        ],
        "JKL7890" => [
            "Auto" => ["marca" => "VOLKSWAGEN", "modelo" => 2022, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "José García", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Juárez 50"]
        ],
        "MNO2345" => [
            "Auto" => ["marca" => "HYUNDAI", "modelo" => 2021, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Lucía Torres", "ciudad" => "Puebla, Pue.", "direccion" => "Calle 5 #12"]
        ],
        "PQR6789" => [
            "Auto" => ["marca" => "KIA", "modelo" => 2020, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Miguel Ortega", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Central 100"]
        ],
        "STU1234" => [
            "Auto" => ["marca" => "MAZDA", "modelo" => 2019, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "Paola Herrera", "ciudad" => "Puebla, Pue.", "direccion" => "Calle Luna 22"]
        ],
        "VWX5678" => [
            "Auto" => ["marca" => "HONDA", "modelo" => 2018, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Fernando Díaz", "ciudad" => "Puebla, Pue.", "direccion" => "Av. Reforma 88"]
        ],
        "YZA9012" => [
            "Auto" => ["marca" => "TOYOTA", "modelo" => 2022, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Sofía Martínez", "ciudad" => "Puebla, Pue.", "direccion" => "Calle Sol 10"]
        ],
        "BCD3456" => [
            "Auto" => ["marca" => "NISSAN", "modelo" => 2021, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Ricardo Gómez", "ciudad" => "Puebla, Pue.", "direccion" => "Av. 5 de Mayo 20"]
        ],
        "EFG7890" => [
            "Auto" => ["marca" => "FORD", "modelo" => 2020, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "Claudia Ruiz", "ciudad" => "Puebla, Pue.", "direccion" => "Calle Primavera 3"]
        ],
        "HIJ2345" => [
            "Auto" => ["marca" => "CHEVROLET", "modelo" => 2019, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Andrés López", "ciudad" => "Puebla, Pue.", "direccion" => "Boulevard 15 de Mayo 45"]
        ],
    ];

    return $vehiculos;
}

?>