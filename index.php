<?php

require('rutes/Router.php');
require('rutes/Request.php');
include_once('php/Cors.php');

session_set_cookie_params(['samesite' => 'none']);

//var_dump($_SERVER);

require Router::carregar('rutes.php')
    ->direct(Request::uri());

