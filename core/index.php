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

    case "followUser":
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $api_key = filter_input(INPUT_POST, "apiKey", FILTER_SANITIZE_STRING);
        
        echo toggleFollowUser($api_key, $username);
        break;

    default:
        die("L'azione richiesta non è valida.");
        break;

}

?>