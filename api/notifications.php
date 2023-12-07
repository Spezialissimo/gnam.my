<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("core/functions.php");

if (isset($_GET["api_key"])) {
    $notificationsCount = count(getNotifications($_GET["api_key"]));
    http_response_code(200);
    echo $notificationsCount;
} else {
    http_response_code(400);
}

?>