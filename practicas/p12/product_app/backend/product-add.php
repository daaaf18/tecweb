<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    use TECWEB\MYAPI\Create\Create;

    $prodObj = new Create('marketzone');
    $prodObj->add($_POST);

    echo $prodObj->getData();
?>