<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    // Usa el método singleByName()
    $prodObj->singleByName($_POST['nombre']);

    echo $prodObj->getData();
?>
