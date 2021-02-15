<?php


if (isset($_POST['session_id'])) {
    session_id($_POST['session_id']);
    session_start();

    if (isset($_SESSION['acces'])) {

        if ($_SESSION['acces'] == "SI") {
            $s = "OK";
        } else {
            $s = "ERROR";
        }

    } else {
        $s = "ERROR_SESSIO";
    }


    echo $s;

}

