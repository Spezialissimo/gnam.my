<?php

require_once('databaseConnection.php');

$key = "28682ecb41c022e5b88686138e40e1d8"; // Da cambiare metodo, la key è un esempio

// Esempio funzione safe
function aggiungiPiattoAMenu($codMenu, $codPiatto) {

    // collegameto al db che abbiamo già
    global $db;

    // preparazione query con placeholders a piacimento (in questo caso :codPiatto e :codMenu)
    $stmt = $db->prepare("INSERT INTO `inserimento` (`codicePiatto`, `codiceMenu`) VALUES (:codPiatto, :codMenu)");

    // assegnazione dei valori ai placeholders
    $stmt->bindParam(':codPiatto', $codPiatto);
    $stmt->bindParam(':codMenu', $codMenu);

    try {
        $stmt->execute();
        return "Piatto inserito nel menù."; // DA cambiare con json
    } catch(PDOException $e) {
        return "Errore nell'esecuzione della query: " . $e->getMessage();
    }
}

function isloggedIn() {
    session_start();
    return isset($_SESSION['id']) && $_SESSION['logged_in'] == "1";
}

function hash_password($password) {
    global $key;
    return hash("SHA256", $password . $key);
 }

function register($username, $password){
    global $db;
    $password_hash = hash_password($password);

    $stmt = $db->prepare("INSERT INTO `users` (`id`, `name`, `password`) VALUES (NULL, :nome, :passwordHash)");
    $stmt->bindParam(':nome', $username);
    $stmt->bindParam(':passwordHash', $password_hash);

    $stmt->execute();
    return json_encode(["status" => "success", "message" => "Utente registrato con successo."]);
}

function getUserFromApiKey($api_key) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `users` WHERE api_key == :api_key");
    $stmt->bindParam(':api_key', $api_key);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getIngredientFromName($ingredient_name) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `ingredients` WHERE name == :name");
    $stmt->bindParam(':name', $ingredient_name);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getHashtagFromText($hashtag_text) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `hashtags` WHERE text == :text");
    $stmt->bindParam(':text', $hashtag_text);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getMeasurementUnitFromName($measurement_unit_name) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM `measurement_units` WHERE name == :name");
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
        WHERE u.api_key == :api_key AND n.seen == 0");
    $stmt->bindParam(':api_key', $api_key);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    usort($notifications, function($n1, $n2) {
        return $n2["timestamp"] <=> $n1["timestamp"];
    });
    return $notifications;
}

?>