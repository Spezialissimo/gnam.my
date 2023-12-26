<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if (isset($_REQUEST["api_key"])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        http_response_code(200);
        echo json_encode(getNotifications($_REQUEST["api_key"]));
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        global $db;
        $query = "UPDATE `notifications` SET `seen` = 1 WHERE `seen` = 0 AND `target_user_id` = :user_id";
        if (isset($_REQUEST["id"])) {
            $query = $query . " AND `id` = :id";
        }

        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', getUserFromApiKey($_REQUEST["api_key"])["id"]);
        if (isset($_REQUEST["id"])) {
            $stmt->bindParam(':id', $_REQUEST["id"]);
        }

        if ($stmt->execute()) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }
} else {
    http_response_code(400);
}

?>