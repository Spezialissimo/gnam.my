<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action']) && isset($_GET['api_key'])) {

    $user = getUserFromApiKey($_GET['api_key']);

    if(!$user) {
        http_response_code(400);
    } else {
        http_response_code(200);

        switch($_GET['action']) {
            case "random":
                echo json_encode(getRandomGnams());
                break;
            case 'byQuery':
                if(isset($_GET['query']) && isset($_GET['ingredients'])) {
                    echo json_encode(searchGnams($_GET['query'], json_decode($_GET['ingredients'])));
                } else {
                    http_response_code(400);
                }
                break;
            default:
                http_response_code(400);
                break;
        }
    }

} else {
    http_response_code(400);
}

?>