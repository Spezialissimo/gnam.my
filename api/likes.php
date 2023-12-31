<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if (isset($_REQUEST["api_key"])) {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['gnam_id'])) {
            $user_id = getUserFromApiKey($_GET["api_key"])["id"];
            $gnam_id = $_GET["gnam_id"];
            http_response_code(200);
            echo json_encode(didUserLikeGnam($gnam_id, $user_id));
        } else {
            http_response_code(400);
        }
    } else if (isset($_POST["action"]) && strtoupper($_POST["action"]) == "TOGGLE_LIKE" && isset($_POST['gnam_id'])) {
        $user_id = getUserFromApiKey($_POST["api_key"])["id"];
        $gnam_id = $_POST["gnam_id"];
        if (didUserLikeGnam($gnam_id, $user_id)) {
            $stmt = $db->prepare("DELETE FROM likes WHERE `likes`.`user_id` = :user_id AND `likes`.`gnam_id` = :gnam_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':gnam_id', $gnam_id);
            $stmt->execute();
        } else {
            $stmt = $db->prepare("INSERT INTO `likes` (`user_id`, `gnam_id`) VALUES (:user_id, :gnam_id);");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':gnam_id', $gnam_id);
            $stmt->execute();
        }
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400);
}
