<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    use TECWEB\MYAPI\Delete\Delete;

    $prodObj = new Delete('marketzone');
    $prodObj->delete($_POST['id']);

    echo $prodObj->getData();
?>