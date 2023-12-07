<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (/*isset($_GET["api_key"])*/true) {
    // TODO: query del database
    http_response_code(200);
    echo 3;
} else {
    http_response_code(400);
}

?>