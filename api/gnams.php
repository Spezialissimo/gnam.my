<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if (isset($_REQUEST["api_key"])) {
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        http_response_code(200);
        if(isset($_GET['gnam'])){
            echo json_encode(getGnamInfoFromId($_GET['gnam']));
        }
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST["action"]) && strtoupper($_POST["action"]) == "CREATE") {
            http_response_code(200);
            if (!isset($_FILES["video"]) || !isset($_FILES["thumbnail"])) {
                http_response_code(400);
            }

            global $db;
            $stmt = $db->prepare("INSERT INTO `gnams` (`user_id`, `description`, `share_count`) VALUES (:user_id, :description, 0)");
            $stmt->bindParam(':user_id', getUserFromApiKey($_POST["api_key"])["id"]);
            $stmt->bindParam(':description', $_POST["description"]);
            $stmt->execute();
            $newVideoId = $db->lastInsertId();

            global $assetsPath;
            $videoFileType = strtolower(pathinfo($_FILES["video"]["name"], PATHINFO_EXTENSION));
            if ($videoFileType === "mp4") {
                move_uploaded_file($_FILES['video']['tmp_name'], $assetsPath . 'gnams/' . $newVideoId . '.' . $videoFileType);
            } else {
                http_response_code(400);
            }

            $imageFileType = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));
            if ($imageFileType === "jpeg") {
                $imageFileType = "jpg";
            }
            if ($imageFileType === "jpg" || $imageFileType === "png") {
                $imagePath = $assetsPath . 'gnams_thumbnails/' . $newVideoId . '.' . $imageFileType;
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], $imagePath);
                if ($imageFileType === "png") {
                    $jpgImage = imagecreatefrompng($imagePath);
                    imagejpeg($jpgImage, $assetsPath . 'gnams_thumbnails/' . $newVideoId . '.jpg');
                    imagedestroy($jpgImage);
                    unlink($imagePath);
                }
            } else {
                http_response_code(400);
            }

            if (isset($_POST["ingredients"])) {
                foreach (json_decode($_POST["ingredients"], true) as $ingredient) {
                    $ingredientId;
                    $ingredientFromDB = getIngredientFromName($ingredient["name"]);
                    if ($ingredientFromDB) {
                        $ingredientId = $ingredientFromDB["id"];
                    } else {
                        $stmt = $db->prepare("INSERT INTO `ingredients` (`name`) VALUES (:name)");
                        $stmt->bindParam(':name', $ingredient["name"]);
                        $stmt->execute();
                        $ingredientId = $db->lastInsertId();
                    }
                    $stmt = $db->prepare("INSERT INTO `gnam_ingredients` (`ingredient_id`, `gnam_id`, `quantity`, `measurement_unit_id`) VALUES (:ingredient_id, :gnam_id, :quantity, :measurement_unit_id)");
                    $stmt->bindParam(':measurement_unit_id', getMeasurementUnitFromName($ingredient["measurement_unit"])["id"]);
                    $stmt->bindParam(':ingredient_id', $ingredientId);
                    $stmt->bindParam(':gnam_id', $newVideoId);
                    if ($ingredient["measurement_unit"] == "qb") {
                        $stmt->bindParam(':quantity', 0);
                    } else {
                        $stmt->bindParam(':quantity', $ingredient["quantity"]);
                    }
                    $stmt->execute();
                }
            }
            if (isset($_POST["hashtags"])) {
                foreach (json_decode($_POST["hashtags"], true) as $hashtag) {
                    $hashtagId;
                    $hashtagFromDB = getHashtagFromText($hashtag);
                    if ($hashtagFromDB) {
                        $hashtagId = $hashtagFromDB["id"];
                    } else {
                        $stmt = $db->prepare("INSERT INTO `hashtags` (`text`) VALUES (:text)");
                        $stmt->bindParam(':text', $hashtag);
                        $stmt->execute();
                        $hashtagId = $db->lastInsertId();
                    }
                    $stmt = $db->prepare("INSERT INTO `gnam_hashtags` (`hashtag_id`, `gnam_id`) VALUES (:hashtag_id, :gnam_id)");
                    $stmt->bindParam(':hashtag_id', $hashtagId);
                    $stmt->bindParam(':gnam_id', $newVideoId);
                    $stmt->execute();
                }
            }
        } else if (isset($_POST["action"]) && strtoupper($_POST["action"]) == "INCREMENT_SHARE") {
            $gnam_id = $_POST["gnam_id"];
            $stmt = $db->prepare("UPDATE `gnams` SET `share_count` = `share_count` + 1 WHERE `id` = :gnam_id");
            $stmt->bindParam(':gnam_id', $gnam_id);
            $stmt->execute();
        } else {
            http_response_code(400);
        }
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400);
}

?>