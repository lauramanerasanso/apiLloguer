<?php
session_start();
include_once 'models/classes/user/User.php';
include_once('models/config/DataBase.php');
include_once 'controlador/userControlador.php';


if (isset($_POST['u']) && isset($_POST['p'])) {

    $userName = $_POST['u'];
    $passwd = $_POST['p'];

    $controlador = new userControlador();
    $acces = $controlador->checkAuth($userName, $passwd);

    if ($acces) {
        $_SESSION['acces'] = "SI";
        echo json_encode([
            'success' => true,
            'session_id' => session_id()
        ]);
    } else {
        echo json_encode([
            'success' => false
        ]);
    }


}