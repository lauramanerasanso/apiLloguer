<?php
include_once('controlador/userControlador.php');
include_once('models/config/DataBase.php');
include_once('models/classes/user/User.php');



if(isset($_POST['oldPasswd']) &&  isset($_POST['newPasswd'])){
    $oldPasswd=$_POST['oldPasswd'];
    $newPasswd=$_POST['newPasswd'];

    $controlador = new userControlador();
    $controlador->changePassword($oldPasswd, $newPasswd);



}