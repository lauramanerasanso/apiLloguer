<?php 
$allowed = ["http://admin.mallorcarustic.me", "https://admin.mallorcarustic.me","http://www.mallorcarustic.me", "https://www.mallorcarustic.me"];
if(in_array($_SERVER['HTTP_ORIGIN'], $allowed)){
    header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
}
header("Access-Control-Allow-Headers: X-API-KEY, X-Requested-With, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Access-Control-Request-Headers: X-PINGOTHER, Content-Type');