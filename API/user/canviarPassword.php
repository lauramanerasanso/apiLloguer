<?php
include_once 'models/classes/user/User.php';
include_once('models/config/DataBase.php');
include_once 'controlador/userControlador.php';


if (isset($_POST['actual']) && isset($_POST['nova']) && isset($_POST['token'])) {

    $actual = $_POST['actual'];
    $nova = $_POST['nova'];
    $token = $_POST['token'];

    $controlador = new userControlador();
    $existeix = $controlador->canviarPasswordCLient($token,$actual,$nova);

    if ($existeix) {

        echo json_encode([
            'success' => true,


        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);

    }


}
