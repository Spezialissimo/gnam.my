<?php

require_once('functions.php');

// TO DO In production leva commento
// error_reporting(0);

$action = key($_GET);

switch ($action) {

    case "register":
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        $rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_STRING);

        if($password != $rpassword) {
            die("Le password non coincidono");
        }
        
        echo register($username, $password);
        break;

    case "login":
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        
        echo login($username, $password);
        break;

    default:
        die("L'azione richiesta non è valida.");
        break;

}

?>