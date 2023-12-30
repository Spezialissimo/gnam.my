<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../core/functions.php");

if (isset($_REQUEST["api_key"])) {
     if ($_SERVER['REQUEST_METHOD'] == "GET") {
        http_response_code(200);
        if(isset($_GET['gnam_id'])){
            echo json_encode(getGnamComments($_GET['gnam_id']));
        }
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        http_response_code(200);
        if(isset($_POST['gnam_id']) && $_POST['text']){
            $user_id = getUserFromApiKey($_REQUEST["api_key"])["id"];
            $parent_id = $_POST["parent_comment_id"] != "" ? $_POST["parent_comment_id"] : null;
            $success = postComment($user_id, $_POST['gnam_id'], $_POST['text'], $parent_id);
            echo json_encode($success);
        }
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(400);
}

?>