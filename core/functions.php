<?php

require_once('databaseConnection.php');

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

?>