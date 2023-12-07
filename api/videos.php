<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_FILES["video"]) && isset($_POST["api_key"])) {
    if (!isset($_POST["thumbnail"])) {
        // TODO: crea e salva thumbnail
    }

    global $db;
    $stmt = $db->prepare("INSERT INTO `gnams` (`user_id`, `description`, `share_count`) VALUES (:user_id, :description, 0)");
    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->execute();
    http_response_code(200);
} else {
    http_response_code(400);
}

?>