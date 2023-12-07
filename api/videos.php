<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_FILES["video"]) && isset($_POST["api_key"])) {
    global $db;
    $stmt = $db->prepare("INSERT INTO `gnams` (`user_id`, `description`, `share_count`) VALUES (:user_id, :description, 0)");
    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->execute();
    $newVideoId = $stmt->insert_id;

    $videoFileType = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
    file_put_contents('../assets/gnams/' . $newVideoId . '.' . $videoFileType, file_get_contents($_FILES["video"]));

    if (!isset($_POST["thumbnail"])) {
        // TODO: crea e salva thumbnail
    } else {
        $imageFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
        file_put_contents('../assets/gnams/' . $newVideoId . '.' . $imageFileType, file_get_contents($_FILES["thumbnail"]));
    }

    http_response_code(200);
} else {
    http_response_code(400);
}

?>