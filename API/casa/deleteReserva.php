<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


if(isset($_POST['codiPagament']) ){

    $controlador = new controlador_casa();

    $codiPag = $_POST['codiPagament'];

    $id = $controlador->deleteReserva($codiPag);
    
    echo $id;

}