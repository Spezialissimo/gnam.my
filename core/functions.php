<?php

require_once('databaseConnection.php');

// Esempio funzione safe
function aggiungiPiattoAMenu($codMenu, $codPiatto) {
    global $db;
    $stmt = $db->prepare("INSERT INTO `inserimento` (`codicePiatto`, `codiceMenu`) VALUES (:codPiatto, :codMenu)");

    $stmt->bindParam(':codPiatto', $codPiatto);
    $stmt->bindParam(':codMenu', $codMenu);

    try {
        $stmt->execute();
        return "Piatto inserito nel menù.";
    } catch(PDOException $e) {        
        return "Errore nell'esecuzione della query: " . $e->getMessage();
    }
}

?>