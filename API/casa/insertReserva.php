<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');
include_once('models/classes/casa/Poblacio.php');
include_once('models/classes/user/User.php');


if(isset($_POST['id_casa']) && isset($_POST['token']) && isset($_POST['data_inici']) && isset($_POST['data_fi']) && isset($_POST['preu_total'])){


    $controlador = new controlador_casa();

    $idCasa = $_POST['id_casa'];
    $token = $_POST['token'];
    $data_inici = $_POST['data_inici'];
    $data_fi = $_POST['data_fi'];
    $preu_total = $_POST['preu_total'];

    $id = $controlador->insertReserva($idCasa, $token, $data_inici, $data_fi, $preu_total);
    
    echo $id;

}