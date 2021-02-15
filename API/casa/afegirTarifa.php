<?php
include_once('controlador/controlador_casa.php');
include_once('models/config/DataBase.php');
include_once('models/classes/casa/Casa.php');



if(isset($_POST['idCasa']) && isset($_POST['preuTarifa']) && isset($_POST['dataInici']) && isset($_POST['dataFi']) && isset($_POST['nomTarifa'])){


    $controlador = new controlador_casa();

    $idCasa = $_POST['idCasa'];
    $preuTarifa = $_POST['preuTarifa'];
    $dataInici = $_POST['dataInici'];
    $dataFi = $_POST['dataFi'];
    $nomTarifa = $_POST['nomTarifa'];

    $result = $controlador->insertTarifa($idCasa, $preuTarifa, $dataInici, $dataFi, $nomTarifa);

    if ($result) {
        echo json_encode([
            'success' => true,
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }

}
