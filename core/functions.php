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

function userExists($user_id) {
    return getUser($user_id) != false;
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
    $stmt = $db->prepare("SELECT u.name AS source_user_name, n.source_user_id, n.id as notification_id, n.gnam_id, nt.template_text, nt.name as notification_type_name, n.timestamp
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

function toggleFollowUser($user_id, $targetUser) {
    global $db;

    if ($user_id == $targetUser) {
        return response("error", "Non puoi seguire te stesso.");
    }

    $userToFollow = getUser($targetUser);
    if ($userToFollow == false) {
        return response("error", "Utente non trovato.");
    }

    $stmt = $db->prepare("SELECT * FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = :followed_user_id");
    $stmt->bindParam(':follower_user_id', $user_id);
    $stmt->bindParam(':followed_user_id', $userToFollow["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        $stmt = $db->prepare("DELETE FROM `following` WHERE `follower_user_id` = :follower_user_id AND `followed_user_id` = :followed_user_id");
        $stmt->bindParam(':follower_user_id', $user_id);
        $stmt->bindParam(':followed_user_id', $userToFollow["id"]);
        $stmt->execute();
        return response("success", "Segui");
    } else {
        $stmt = $db->prepare("INSERT INTO `following` (`follower_user_id`, `followed_user_id`) VALUES (:follower_user_id, :followed_user_id)");
        $stmt->bindParam(':follower_user_id', $user_id);
        $stmt->bindParam(':followed_user_id', $userToFollow["id"]);
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

    $gnamUserName = getUser($gnam['user_id'])["name"];
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
    $stmt = $db->prepare("SELECT id FROM gnams g ORDER BY RAND()");
    $stmt->execute();
    $gnams = array_column($stmt->fetchAll(PDO::FETCH_ASSOC),'id');
    return $gnams;
}

//TODO VANNO UNIFICATI I RISULTATI DELLE 4 QUERY (che ora sono in $queryDesc, $queryHashtag, $queryIngredients, $queryUsers)
function searchGnams($query, $ingredients) {
    global $db;

    // QUERY 1 (seleziona per desc tipo %torta%mele%)
    $words = explode(" ", $query);
    $words[0] = '%' . $words[0];
    $words[count($words) - 1] .= '%';
    $finalQuery = implode('%', $words);

    $stmt = $db->prepare("SELECT id FROM gnams WHERE `description` LIKE :query");
    $stmt->bindValue(':query', $finalQuery);
    $stmt->execute();
    $queryDesc = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $queryDesc = array_column($queryDesc, "id");

    // QUERY 2 (tutti gli gnam che hanno un utente, con un nome che contiene una delle parole della query)
    $temp = [];
    $words = explode(" ", $query);
    foreach ($words as $word) {
        $stmt = $db->prepare("SELECT g.id FROM gnams g
            JOIN users u ON g.user_id = u.id
            WHERE u.name LIKE '%" . $word . "%'");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $temp[] = $result;
        }
    }
    $queryUsers = call_user_func_array('array_merge', $temp);
    $queryUsers = array_column($queryUsers, "id");

    // QUERY 3 (seleziona tutti gli gnam che hanno 1 o più hashtag presenti nella query)
    preg_match_all('/#(\w+)/', $query, $matches);
    $hashtags = $matches[1];

    $stmt = $db->prepare("SELECT g.id FROM gnams g
        JOIN gnam_hashtags gh ON g.id=gh.gnam_id
        JOIN hashtags h ON gh.hashtag_id=h.id
        WHERE h.text IN ('" . implode("','", $hashtags) . "')");
    $stmt->execute();
    $queryHashtag = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $queryHashtag = array_column($queryHashtag, "id");

    // QUERY 4 (tutti gli gnam che hanno tutti gli ingredienti presenti in $ingredients)
    $stmt = $db->prepare("SELECT g.id FROM gnams g
        JOIN gnam_ingredients gi ON g.id=gi.gnam_id
        JOIN ingredients i ON gi.ingredient_id=i.id
        WHERE i.name IN ('" . implode("','", $ingredients) . "')
        GROUP BY g.id HAVING COUNT(DISTINCT i.name) = " . count($ingredients));
    $stmt->execute();
    $queryIngredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $queryIngredients = array_column($queryIngredients, "id");

    // merge ids from desc search and user search
    $results = array_unique(array_merge($queryDesc, $queryUsers));
    // if there were some hashtags in the query we must filter
    if (!empty($hashtags)) {
        // if the query did not contain anything else other than the hashtag
        if (empty($results)) {
            $results = $queryHashtag;
        } else {
            $results = array_intersect($results, $queryHashtag);
        }
    }
    // if there were some ingredients in the query we must filter
    if (!empty($ingredients)) {
        if (empty($results)) {
            $results = $queryIngredients;
        } else {
            $results = array_intersect($results, $queryIngredients);
        }
    }

    $resultsWithId = array();
    foreach ($results as $result) {
        array_push($resultsWithId, array("id" => $result));
    }
    return $resultsWithId;
}

function getGnamComments($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT c.*, u.name as user_name
        FROM comments c JOIN users u ON c.user_id=u.id
        WHERE gnam_id=:gnam_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGnamTags($gnam_id) {
    global $db;
    $stmt = $db->prepare("SELECT ht.text FROM
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
    (:current_user, :gnam_id, :parent_comment_id, :text, :timestamp)");

    $stmt->bindParam(':current_user', $currentUser_id);
    $stmt->bindParam(':parent_comment_id', $parent_comment_id);
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->bindParam(':text', $comment);
    $stmt->bindParam(':timestamp', $timestamp);

    return $stmt->execute();
}

function formatTimestampDiff($t1, $t2) {
    $diff = $t2 - $t1;
    if ($diff > 60 * 60 * 24) {
        return floor($diff / (60 * 60 * 24)) . " d";
    } else if ($diff > 60 * 60) {
        return floor($diff / (60 * 60)) . " h";
    } else if ($diff > 60) {
        return floor($diff / 60) . " m";
    } else {
        return $diff . " s";
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

function didUserLikeGnam($gnam_id, $user_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `likes` WHERE `gnam_id`=:gnam_id AND `user_id`=:user_id");
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result == false ? false : true;
}

function addNotification($source_user_id, $target_user_id, $gnam_id, $notification_type_id) {
    global $db;
    $timestamp = time();
    $stmt = $db->prepare("INSERT INTO `notifications` (`source_user_id`, `target_user_id`, `gnam_id`, `notification_type_id`, `timestamp`) VALUES (:source_user_id, :target_user_id, :gnam_id, :notification_type_id, :timestamp)");
    $stmt->bindParam(':source_user_id', $source_user_id);
    $stmt->bindParam(':target_user_id', $target_user_id);
    $stmt->bindParam(':gnam_id', $gnam_id);
    $stmt->bindParam(':notification_type_id', $notification_type_id);
    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->execute();
    return response("success", "Notifica aggiunta.");
}

function deleteNotification($source_user_id, $target_user_id, $gnam_id, $notification_type_id) {
    global $db;
    if($gnam_id == null) {
        $stmt = $db->prepare("DELETE FROM `notifications` WHERE `source_user_id` = :source_user_id AND `target_user_id` = :target_user_id AND `gnam_id` IS NULL AND `notification_type_id` = :notification_type_id");
        $stmt->bindParam(':source_user_id', $source_user_id);
        $stmt->bindParam(':target_user_id', $target_user_id);
        $stmt->bindParam(':notification_type_id', $notification_type_id);
        $stmt->execute();
    } else {
        $stmt = $db->prepare("DELETE FROM `notifications` WHERE `source_user_id` = :source_user_id AND `target_user_id` = :target_user_id AND `gnam_id` = :gnam_id AND `notification_type_id` = :notification_type_id");
        $stmt->bindParam(':source_user_id', $source_user_id);
        $stmt->bindParam(':target_user_id', $target_user_id);
        $stmt->bindParam(':gnam_id', $gnam_id);
        $stmt->bindParam(':notification_type_id', $notification_type_id);
        $stmt->execute();
    }
    return response("success", "Notifica eliminata.");
}