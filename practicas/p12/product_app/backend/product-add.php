<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzone');
    // El método add() recibe el array $_POST
    $prodObj->add($_POST);

    echo $prodObj->getData();
?>