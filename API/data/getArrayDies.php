<?php
include_once('controlador/controlador_data.php');
include_once ('models/config/DataBase.php');
include_once ('models/classes/data/Data.php');

$controlador = new controlador_data();

if( isset($_POST['id']) && isset($_POST['anyMes']) ) {

    $id = $_POST['id'];

    $anyMes = $_POST['anyMes'];

    $controlador->arrayDies($id, $anyMes);


}else{

    $controlador->arrayDies(2, "2021-05");

}