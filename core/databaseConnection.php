<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_gnammy');
define('DB_USER', 'gnammy');
define('DB_PASSWORD', 'gnammy');

// Opzioni per query safe
$options = [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD, $options);
} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

date_default_timezone_set('Europe/Rome');

// Sanificazione veloce POST
foreach($_POST as $value) {
    $value = htmlspecialchars($value);
    $value = $db->quote($value);
}

?>