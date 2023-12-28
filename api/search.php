<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action']) && isset($_GET['api_key'])) {

    switch($_GET['action']) {
        case "byUsername":
            if (isset($_GET['username'])) {
                http_response_code(200);

                $user = getUserFromApiKey($_GET['api_key']);

                if($user) {
                    echo json_encode(getUserGnams($_GET['username']));
                } else {
                    http_response_code(400);
                    echo response("error", "Invalid API key.");
                }
            } else {
                http_response_code(400);
            }
            break;
        case "random":
            // TODO mettere su tutto? non ho capito perche` pier l'ha messo detro
            if (isset($_GET['api_key'])) {
                echo json_decode(getRandomGnams());
            }
        default:
            http_response_code(400);
            break;
    }

} else {
    http_response_code(400);
}

?>