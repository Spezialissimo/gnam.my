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

?>