<?php

require_once('functions.php');

// TO DO In production leva commento
// error_reporting(0);

// Azione richiesta
$action = key($_GET);

switch ($action) {

    case "signin":
        // Sanificazione veloce
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        $rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_STRING);

        if($password != $rpassword) {
            die("Le password non coincidono"); //DA cambiare con json
        }

        // Chiamata a funzione vera e propria
        // la funzione deve ritornare un json con stato e dati
        // il json viene parsato da jquery che si occupa di mostrare il toast
        echo register($username, $password);
        break;

    // Altri case ovviamente

    default:
        die("L'azione richiesta non è valida.");
        break;

}

?>