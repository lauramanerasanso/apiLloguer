<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


if (isset($_POST['idCasa']) && isset($_POST['dataInici'])) {

    $controlador = new controlador_casa();

    $idCasa = $_POST['idCasa'];
    $dataInici = $_POST['dataInici'];

    $result = $controlador->deleteBloq($idCasa, $dataInici);

    if ($result) {
        echo json_encode([
            'success' => true
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }
}