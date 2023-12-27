<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['action'])) {
    
    switch($_POST['action']) {
        case "register":
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rpassword'])) {
                http_response_code(200);

                $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
                $rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_STRING);

                if($password != $rpassword) {
                    die("Le password non coincidono");
                }

                echo register($username, $password);
            } else {
                http_response_code(400);
            }
            break;

        case "toggleFollowState":
            if (isset($_POST['username']) && isset($_POST['api_key'])) {
                http_response_code(200);
                
                $api_key = filter_input(INPUT_POST, "api_key", FILTER_SANITIZE_STRING);
                $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
                
                echo toggleFollowUser($api_key, $username);
            } else {
                http_response_code(400);
            }
            break;
            
        default:
            http_response_code(400);
            break;
    }

} else {
    http_response_code(400);
}

?>