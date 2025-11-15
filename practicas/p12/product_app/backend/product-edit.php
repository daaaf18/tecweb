<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    use TECWEB\MYAPI\Update\Update;

    $prodObj = new Update('marketzone');
    $prodObj->edit($_POST);

    echo $prodObj->getData();
?>