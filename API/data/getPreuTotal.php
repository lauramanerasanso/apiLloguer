<?php
include_once('controlador/controlador_data.php');
include_once('models/config/DataBase.php');
include_once('models/classes/data/Data.php');

$controlador = new controlador_data();

if( isset($_POST['id']) && isset($_POST['dataInici']) && isset($_POST['dataFi'])) {

    $id = $_POST['id'];
    $dataInici = $_POST['dataInici'];
    $dataFi = $_POST['dataFi'];

    $preu = $controlador->preuTotalDates($id, $dataInici, $dataFi);
    echo json_encode($preu);
}else{
    $id = 3;
    $dataInici = '2021-03-25';
    $dataFi = '2021-04-02';

    $preu = $controlador->preuTotalDates($id, $dataInici, $dataFi);
    echo json_encode($preu);
}