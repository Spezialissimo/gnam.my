<?php

require_once('databaseConnection.php');

$assetsPath = str_replace("core", "assets", __DIR__) . DIRECTORY_SEPARATOR;

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

function register($username, $password) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM `users` WHERE `name` = :nome");
    $stmt->bindParam(':nome', $username);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        return response("error", "Username già in uso.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $apiKey = generateUUID();

    $stmt = $db->prepare("INSERT INTO `users` (`id`, `api_key`, `name`, `password`) VALUES (NULL, :apiKey, :nome, :passwordHash)");
    $stmt->bindParam(':apiKey', $apiKey);
    $stmt->bindParam(':nome', $username);
    $stmt->bindParam(':passwordHash', $hashed_password);
    $stmt->execute();

    return response("success", "Utente registrato.");
}

function login($username, $password) {
    global $db;

    $stmt = $db->prepare("SELECT * FROM `users` WHERE `name` = :nome");
    $stmt->bindParam(':nome', $username);
    $stmt->execute();
    $rows = $stmt->fetch();

    if (!$rows) {
        return response("error", "Nessun utente trovato.");
    }

    $real_password = ($rows['password']);
    if (password_verify($password, $real_password)) {
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

function userExits($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return count($rows) > 0;

}

function getUserFromApiKey($api_key) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `users` WHERE api_key = :api_key");
    $stmt->bindParam(':api_key', $api_key);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUser($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `users` WHERE id = :id");
    $stmt->bindParam(':id', $user_id);
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
    global $db;
    $stmt = $db->prepare("SELECT u.name AS source_user_name, n.source_user_id, n.id as notification_id, n.gnam_id, nt.template_text, n.timestamp
        FROM (`notifications` AS n INNER JOIN `users` AS u ON n.source_user_id = u.id) INNER JOIN `notification_types` AS nt ON n.notification_type_id = nt.id
        WHERE n.target_user_id = :user_id AND n.seen = 0
        ORDER BY n.timestamp DESC");
    $stmt->bindParam(':user_id', getUserFromApiKey($api_key)["id"]);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $notifications;
}

function getUserFollowers($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT u.id, u.name FROM `users` AS u
        INNER JOIN `following` AS f
        ON u.id = f.follower_user_id
        WHERE f.followed_user_id = :user_id
        ORDER BY u.name ASC");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserFollowed($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT u.id, u.name FROM `users` AS u
        INNER JOIN `following` AS f
        ON u.id = f.followed_user_id
        WHERE f.follower_user_id = :user_id
        ORDER BY u.name ASC");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isCurrentUserFollowing($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = :followed_user_id");
    $stmt->bindParam(':follower_user_id', $_SESSION["id"]);
    $stmt->bindParam(':followed_user_id', $user_id);
    $stmt->execute();
    return count($stmt->fetchAll(PDO::FETCH_ASSOC)) > 0;
}

function toggleFollowUser($api_key, $user_id) {
    global $db;
    $currentUser = getUserFromApiKey($api_key);

    if ($currentUser["id"] == $user_id) {
        return response("error", "Non puoi seguire te stesso.");
    }

    $stmt = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $userToFollow = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($userToFollow) == 0) {
        return response("error", "Utente non trovato.");
    }

    $stmt = $db->prepare("SELECT * FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = :followed_user_id");
    $stmt->bindParam(':follower_user_id', $currentUser["id"]);
    $stmt->bindParam(':followed_user_id', $userToFollow[0]["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
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

function getGnamInfoFromId($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT *
        FROM gnams WHERE id=:gnam_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->execute();
    $gnam = $stmt->fetch(PDO::FETCH_ASSOC);

    $gnamUserName = getGnamUserName($gnam['user_id']);
    $gnamTags = getGnamTags($gnam['id']);
    $gnamLikes = getGnamLikes($gnam['id']);
    $gnamRecipe = getGnamRecipe($gnam['id']);
    return [
        'id' => $gnam['id'],
        'shares_count' => $gnam['share_count'],
        'short_description' => substr($gnam['description'], 0, 97) . '...',
        'description' => $gnam['description'],
        'user_name' => $gnamUserName,
        'user_id' => $gnam['user_id'],
        'tags' => $gnamTags,
        'likes_count' => $gnamLikes,
        'recipe' => $gnamRecipe
    ];
}

function getRandomGnams() {
    global $db;
    $stmt = $db->prepare("SELECT id FROM gnams g ORDER BY RAND() LIMIT 5");
    $stmt->execute();
    $gnams = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $gnams;
}

function searchGnams($query) {
    global $db;

    //Check if exists an user with username = $query
    $stmt = $db->prepare("SELECT * FROM users WHERE `name` = :query");
    $stmt->bindParam(':query', $query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        return getUserGnams($result[0]['id']);
    } else {
        $stmt = $db->prepare("SELECT * FROM gnams WHERE `description` LIKE :query");
        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->execute();
        $gnams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $gnams;
    }
}

function getGnamUserName($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT `name` FROM users WHERE id=:user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return ($stmt->fetch(PDO::FETCH_ASSOC))['name'];
}

// TODO ordina per timestamp
function getGnamComments($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM comments WHERE gnam_id=:gnam_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGnamTags($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT ht.text, ht.icon FROM
        hashtags ht JOIN gnam_hashtags ght ON ht.id=ght.hashtag_id
        WHERE ght.gnam_id=:gnam_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGnamLikes($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT COUNT(*) AS likes_count FROM likes WHERE gnam_id=:gnam_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->execute();
    return ($stmt->fetch(PDO::FETCH_ASSOC))['likes_count'];
}

function getGnamRecipe($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT
        i.name as `name`, gi.quantity as quantity, mu.name as measurement_unit
        FROM gnam_ingredients gi
        JOIN ingredients i ON gi.ingredient_id=i.id
        JOIN measurement_units mu ON gi.measurement_unit_id=mu.id
        WHERE gnam_id=:gnam_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function postComment($currentUser_id, $gnam_id, $comment, $parent_comment_id) {
    global $db;
    $stmt = null;
    $timestamp = time();
    $stmt = $db->prepare("INSERT INTO `comments`
        (`user_id`, `gnam_id`, `parent_comment_id`, `text`, `timestamp`)
            VALUES
        (':current_user', ':gnam_id', ':parent_comment_id', ':text', ':timestamp');");
    $stmt->bindParam(':current_user', $currentUser_id);
    $stmt->bindParam(':parent_comment_id', $parent_comment_id); // se non c'é è null
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->bindParam(':text', $comment);
    $stmt->bindParam(':timestamp', $timestamp);
    $success = $stmt->execute();

    return $success;
}

// TODO mi sa che questo l'avevo fatto io (davide) per sbaglio, se non lo si usa e da radiare
function getNewGnamsForSearch($ingredients, $textfield, $api_key) {
    global $db;

    if ($ingredients === null && ($textfield === null || $textfield === '')) {
        return null;
    }

    $sql = "SELECT *
        FROM gnam g
        JOIN gnam_ingredients gi ON g.gnam_id = gi.gnam_id
        JOIN ingredients i ON gi.ingredient_id = i.ingredient_id
        WHERE 1 = 1";

    if ($textfield !== null && $textfield !== '') {
        $sql .= " AND g.description LIKE :textfield";
    }

    if ($ingredients !== null && !empty($ingredients)) {
        $placeholders = implode(',', array_fill(0, count($ingredients), '?'));
        $sql .= " AND i.name IN ($placeholders)";
    }

    $stmt = $db->prepare($sql);

    if ($textfield !== null && $textfield !== '') {
        $stmt->bindParam(':textfield', $textfield);
    }

    if ($ingredients !== null && !empty($ingredients)) {
        foreach ($ingredients as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }
    }

    $stmt->execute();
    $gnams = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $gnams;
}

function getPrettyTimeDiff($t1, $t2) {
    $t1 = new DateTime(date('Y/m/d h:i:s', $t1));
    $t2 = new DateTime(date('Y/m/d h:i:s', $t2));
    $interval = $t2->diff($t1);
    $days = $interval->format("%d");
    if ($days > 0) {
        return $days . "d";
    } else {
        $hours = $interval->format("%H");
        if ($hours > 0) {
            return $hours . "h";
        } else {
            $minutes = $interval->format("%m");
            if ($minutes > 0) {
                return $minutes . "m";
            } else {
                return $interval->format("%s") . "s";
            }
        }
    }
}

function getUserGnams($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `gnams` WHERE `user_id` = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUserLikedGnams($user_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `likes` WHERE `user_id` = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}