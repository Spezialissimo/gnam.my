<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if (isset($_FILES["video"]) && isset($_FILES["thumbnail"]) && isset($_POST["api_key"])) {
    global $db;
    $stmt = $db->prepare("INSERT INTO `gnams` (`user_id`, `description`, `share_count`) VALUES (:user_id, :description, 0)");
    $stmt->bindParam(':user_id', getUserFromApiKey($_POST["api_key"])["id"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->execute();
    $newVideoId = $stmt->insert_id;

    $videoFileType = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
    file_put_contents('../assets/gnams/' . $newVideoId . '.' . $videoFileType, file_get_contents($_FILES["video"]));

    $imageFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
    file_put_contents('../assets/gnams_thumbnails/' . $newVideoId . '.' . $imageFileType, file_get_contents($_FILES["thumbnail"]));

    if (isset($_POST["ingredients"]) && count($_POST["ingredients"]) > 0) {
        foreach ($_POST["ingredients"] as $ingredient) {
            $stmt = $db->prepare("INSERT INTO `gnam_ingredients` (`ingredient_id`, `gnam_id`, `quantity`, `measurement_unit_id`) VALUES (:ingredient_id, :gnam_id, :quantity, :measurement_unit_id)");
            $stmt->bindParam(':measurement_unit_id', getMeasurementUnitFromName($ingredient["measurement_unit"])["id"]);
            $stmt->bindParam(':ingredient_id', getIngredientFromName($ingredient["name"])["id"]);
            $stmt->bindParam(':gnam_id', $newVideoId);
            $stmt->bindParam(':quantity', $ingredient["quantity"]);
            $stmt->execute();
        }
    }
    if (isset($_POST["hashtags"]) && count($_POST["hashtags"]) > 0) {
        foreach ($_POST["hashtags"] as $hashtag) {
            $stmt = $db->prepare("INSERT INTO `gnam_hashtags` (`hashtag_id`, `gnam_id`) VALUES (:hashtag_id, :gnam_id)");
            $stmt->bindParam(':hashtag_id', getHashtagFromText($hashtag["text"])["id"]);
            $stmt->bindParam(':gnam_id', $newVideoId);
            $stmt->execute();
        }
    }

    http_response_code(200);
} else {
    http_response_code(400);
}

?>