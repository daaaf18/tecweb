<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    use TECWEB\MYAPI\Read\Read;

    $prodObj = new Read('marketzone');
    $prodObj->search($_GET['search']);

    echo $prodObj->getData();
?>