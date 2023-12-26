<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if (isset($_REQUEST["api_key"])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            http_response_code(200);
            // TODO
            break;

        case 'POST':
            if (!isset($_FILES["video"]) || !isset($_FILES["thumbnail"])) {
                http_response_code(400);
            }

            global $db;
            $stmt = $db->prepare("INSERT INTO `gnams` (`user_id`, `description`, `share_count`) VALUES (:user_id, :description, 0)");
            $stmt->bindParam(':user_id', getUserFromApiKey($_POST["api_key"])["id"]);
            $stmt->bindParam(':description', $_POST["description"]);
            $stmt->execute();
            // $newVideoId = $stmt->lastInsertId(); TODO NON FUNZIONA PERCHÈ BOH
            $newVideoId = 19;

            /*
            $videoFileType = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
            file_put_contents('../assets/gnams/' . $newVideoId . '.' . $videoFileType, file_get_contents($_FILES["video"]));

            $imageFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
            file_put_contents('../assets/gnams_thumbnails/' . $newVideoId . '.' . $imageFileType, file_get_contents($_FILES["thumbnail"]));
            */

            if (isset($_POST["ingredients"])) {
                foreach (json_decode($_POST["ingredients"], true) as $ingredient) {
                    $stmt = $db->prepare("INSERT INTO `gnam_ingredients` (`ingredient_id`, `gnam_id`, `quantity`, `measurement_unit_id`) VALUES (:ingredient_id, :gnam_id, :quantity, :measurement_unit_id)");
                    $stmt->bindParam(':measurement_unit_id', getMeasurementUnitFromName($ingredient["measurement_unit"])["id"]);
                    $stmt->bindParam(':ingredient_id', getIngredientFromName($ingredient["name"])["id"]);
                    $stmt->bindParam(':gnam_id', $newVideoId);
                    $stmt->bindParam(':quantity', $ingredient["quantity"]);
                    $stmt->execute();
                }
            }
            if (isset($_POST["hashtags"])) {
                foreach (json_decode($_POST["hashtags"], true) as $hashtag) {
                    $stmt = $db->prepare("INSERT INTO `gnam_hashtags` (`hashtag_id`, `gnam_id`) VALUES (:hashtag_id, :gnam_id)");
                    $stmt->bindParam(':hashtag_id', getHashtagFromText($hashtag)["id"]);
                    $stmt->bindParam(':gnam_id', $newVideoId);
                    $stmt->execute();
                }
            }
            http_response_code(200);
            break;

        case 'PUT':
            // TODO
            break;

        default:
            http_response_code(400);
            break;
    }
}

?>