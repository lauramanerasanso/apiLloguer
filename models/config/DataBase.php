<?php


class DataBase{

    public static $conn;

    public static function getConn(){
        $credencials = require 'login.php';
        if(isset($conn)) {
            return static::$conn;
        }else{
            static::$conn = new mysqli($credencials['servername'], $credencials['username'], $credencials['password'], $credencials['dbname']);
            return static::$conn;
        }

    }
}