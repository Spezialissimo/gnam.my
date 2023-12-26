<?php

require_once('databaseConnection.php');

$key = "28682ecb41c022e5b88686138e40e1d8"; // Da cambiare metodo, la key è un esempio

function response($type, $message) {
    return json_encode(["status" => $type, "message" => $message]);
}

function generateUUID() {
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isloggedIn() {
    if (session_status() == PHP_SESSION_NONE) {
        session_name("secure");
        session_start();
    }
    return isset($_SESSION['id']) && isset($_SESSION['api_key']);
}

function hash_password($password) {
    global $key;
    return hash("SHA256", $password . $key);
 }

function register($username, $password) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM `users` WHERE `name` = :nome");
    $stmt->bindParam(':nome', $username);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($rows) > 0) {
        return response("error", "Username già in uso.");
    }

    $password_hash = hash_password($password);
    $apiKey = generateUUID();

    $stmt = $db->prepare("INSERT INTO `users` (`id`, `api_key`, `name`, `password`) VALUES (NULL, :apiKey, :nome, :passwordHash)");
    $stmt->bindParam(':apiKey', $apiKey);
    $stmt->bindParam(':nome', $username);
    $stmt->bindParam(':passwordHash', $password_hash);
    $stmt->execute();

    return login($username, $password);
}

function login($username, $password) {
    global $db;
    global $key;
    
    $stmt = $db->prepare("SELECT * FROM `users` WHERE `name` = :nome");
    $stmt->bindParam(':nome', $username);
    $stmt->execute();
    $rows = $stmt->fetch();

    $password_hash = hash_password($password);
    $real_password = ($rows['password']);

    if($password_hash == $real_password) {
            session_name("secure");
            session_start();
            
			$_SESSION['id'] = $rows['id'];			
            $_SESSION['api_key'] = $rows['api_key'];
            $_SESSION['username'] = $rows['name'];
            
            return response("success", "Fatto! Ti stiamo reindirizzando...");
    } else {
        return response("error", "Credenziali non valide.");
    }
}

function logout() {
    session_name("secure");
    session_start();
    session_destroy();
    header("Location: login.php");
}

function getUserFromApiKey($api_key) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `users` WHERE api_key = :api_key");
    $stmt->bindParam(':api_key', $api_key);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getIngredientFromName($ingredient_name) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `ingredients` WHERE `name` = :name");
    $stmt->bindParam(':name', $ingredient_name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getHashtagFromText($hashtag_text) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `hashtags` WHERE `text` = :text");
    $stmt->bindParam(':text', $hashtag_text);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMeasurementUnitFromName($measurement_unit_name) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `measurement_units` WHERE `name` = :name");
    $stmt->bindParam(':name', $measurement_unit_name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getNotifications($api_key) {
    // $notifications = array(
            // array("source_user_name" => "NoyzNachos", "gnam_id" => "2", "template_text" => " ciao!", "timestamp" => "2"),
            // array("source_user_name" => "SferaEImpasta", "gnam_id" => "2", "template_text" => " ciao!", "timestamp" => "4")
    // );

    global $db;
    $stmt = $db->prepare("SELECT u.name AS source_user_name, n.gnam_id, nt.template_text, n.timestamp
        FROM (`notifications` AS n INNER JOIN `users` AS u ON n.target_user_id = u.id) INNER JOIN `notification_types` AS nt ON n.notification_type_id = nt.id
        WHERE u.api_key = :api_key AND n.seen = 0");
    $stmt->bindParam(':api_key', $api_key);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    usort($notifications, function($n1, $n2) {
        return $n2["timestamp"] <=> $n1["timestamp"];
    });
    return $notifications;
}

function getUserFollowers($username) {
    global $db;
    $stmt = $db->prepare("SELECT u.name, u.profile_picture FROM `users` AS u
        INNER JOIN `following` AS f
        ON u.id = f.follower_user_id
        WHERE f.followed_user_id = (SELECT id FROM `users` WHERE `name` = :username)
        ORDER BY u.name ASC");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserFollowed($username) {
    global $db;
    $stmt = $db->prepare("SELECT u.name, u.profile_picture FROM `users` AS u
        INNER JOIN `following` AS f
        ON u.id = f.followed_user_id
        WHERE f.follower_user_id = (SELECT id FROM `users` WHERE `name` = :username)
        ORDER BY u.name ASC");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isCurrentUserFollowing($username) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = (SELECT id FROM `users` WHERE `name` = :username)");
    $stmt->bindParam(':follower_user_id', $_SESSION["id"]);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0;
}

function toggleFollowUser($api_key, $username) {
    global $db;
    $currentUser = getUserFromApiKey($api_key);

    if($currentUser["name"] == $username) {
        return response("error", "Non puoi seguire te stesso.");
    }

    $stmt = $db->prepare("SELECT * FROM `users` WHERE `name` = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $userToFollow = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($userToFollow) == 0) {
        return response("error", "Utente non trovato.");
    }

    $stmt = $db->prepare("SELECT * FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = :followed_user_id");
    $stmt->bindParam(':follower_user_id', $currentUser["id"]);
    $stmt->bindParam(':followed_user_id', $userToFollow[0]["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(count($rows) > 0) {
        $stmt = $db->prepare("DELETE FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = :followed_user_id");
        $stmt->bindParam(':follower_user_id', $currentUser["id"]);
        $stmt->bindParam(':followed_user_id', $userToFollow[0]["id"]);
        $stmt->execute();
        return response("success", "Segui");
    } else {
        $stmt = $db->prepare("INSERT INTO `following` (`follower_user_id`, `followed_user_id`) VALUES (:follower_user_id, :followed_user_id)");
        $stmt->bindParam(':follower_user_id', $currentUser["id"]);
        $stmt->bindParam(':followed_user_id', $userToFollow[0]["id"]);
        $stmt->execute();
        return response("success", "Seguito");
    }
}

?>