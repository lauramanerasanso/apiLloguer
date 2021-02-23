<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');


if(isset($_POST['idCasa']) && isset($_POST['dataInici']) && isset($_POST['dataIniciNew']) && isset($_POST['dataFiNew'])
    && isset($_POST['nomTarifa']) && isset($_POST['nomNew']) && isset($_POST['preuNew']) && isset($_POST['dataFi'])){


    $controlador = new controlador_casa();

    $idCasa = $_POST['idCasa'];
    $dataInici = $_POST['dataInici'];
    $dataIniciNew = $_POST['dataIniciNew'];
    $dataFiNew = $_POST['dataFiNew'];
    $dataFi = $_POST['dataFi'];
    $nomTarifa = $_POST['nomTarifa'];
    $nomNew = $_POST['nomNew'];
    $preuNew = $_POST['preuNew'];

    $result = $controlador->updateAppTarifa($idCasa, $dataInici, $dataIniciNew, $dataFi, $dataFiNew, $nomTarifa, $nomNew, $preuNew);

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