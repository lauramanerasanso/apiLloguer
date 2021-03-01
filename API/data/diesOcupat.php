<?php
include_once('controlador/controlador_data.php');
include_once('models/config/DataBase.php');
include_once('models/classes/data/Data.php');

$controlador = new controlador_data();

if( isset($_POST['id'])) {
    $id = $_POST['id'];

    $dates = $controlador->intervalDates($id);

    echo json_encode($dates);
}