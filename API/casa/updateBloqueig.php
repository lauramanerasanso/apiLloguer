<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


if(isset($_POST['idCasa']) && isset($_POST['dataInici']) && isset($_POST['dataIniciNew']) && isset($_POST['dataFiNew'])){


    $controlador = new controlador_casa();

    $idCasa = $_POST['idCasa'];
    $dataInici = $_POST['dataInici'];
    $dataIniciNew = $_POST['dataIniciNew'];
    $dataFiNew = $_POST['dataFiNew'];

    $result = $controlador->updateBloq($idCasa, $dataInici, $dataIniciNew, $dataFiNew);

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