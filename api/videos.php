<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_FILES["video"]) && isset($_POST["api_key"])) {
    if (!isset($_POST["thumbnail"])) {
        // TODO: crea thumbnail
    }

    // TODO: upload del video sull'utente con quella certa api_key
    http_response_code(200);
} else {
    http_response_code(400);
}

?>