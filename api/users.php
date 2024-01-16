<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['action'])) {
    switch($_POST['action']) {
        case "register":
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rpassword'])) {
                http_response_code(200);

                $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
                $rpassword = filter_input(INPUT_POST, "rpassword", FILTER_SANITIZE_STRING);

                if($password != $rpassword) {
                    die("Le password non coincidono");
                }

                $msg = register($username, $password);
                if(json_decode($msg, true)["message"] == "Utente registrato.") {
                    $lastUserId = $db->lastInsertId();
                    $sourceImage = $assetsPath . 'default_image.jpg';
                    $destinationImage = $assetsPath . 'profile_pictures/' . $lastUserId . '.jpg';
                    copy($sourceImage, $destinationImage);
                }
                echo $msg;
            } else {
                http_response_code(400);
            }
            break;

        case "toggleFollowState":
            if (isset($_POST['user_id']) && isset($_POST['api_key'])) {
                http_response_code(200);

                $api_key = filter_input(INPUT_POST, "api_key", FILTER_SANITIZE_STRING);
                $targetUser = filter_input(INPUT_POST, "user_id", FILTER_SANITIZE_STRING);
                $currentUser = getUserFromApiKey($api_key)["id"];

                if(json_decode(toggleFollowUser($currentUser, $targetUser), true)["message"] == "Segui") {
                    if($targetUser != $currentUser) {
                        deleteNotification($currentUser, $targetUser, null, 3);
                    }
                    echo response("success", "Segui");
                } else {
                    if($targetUser != $currentUser) {
                        addNotification($currentUser, $targetUser, null, 3);
                    }
                    echo response("success", "Seguito");
                }
            } else {
                http_response_code(400);
            }
            break;

        case "updateProfileImage":
            if (isset($_FILES['image']) && isset($_POST['api_key'])) {
                http_response_code(200);

                $user_id = getUserFromApiKey($_POST['api_key'])['id'];
                $fileExtension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
                $imagePath = $assetsPath . 'profile_pictures/' . $user_id . '.' . $fileExtension;

                if ($fileExtension === "jpg") {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        echo json_encode(['status' => 'success', 'message' => 'Immagine aggiornata con successo']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['status' => 'error', 'message' => 'Errore durante il caricamento dell\'immagine']);
                    }
                } else {
                    http_response_code(400);
                }
            } else {
                http_response_code(400);
            }
            break;

        default:
            http_response_code(400);
            break;
    }
} else {
    http_response_code(400);
}

?>