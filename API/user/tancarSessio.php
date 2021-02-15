<?php

if (isset($_POST['session_id'])) {
    session_id($_POST['session_id']);
    session_start();

    if (isset($_SESSION['acces'])) {

        session_destroy();
        $s = "OK";

    } else {
        $s = "ERROR";
    }


    echo $s;

}