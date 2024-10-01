<?php

define('DB_HOST', 'db');
define('DB_NAME', 'gnammy_db');
define('DB_USER', 'user');
define('DB_PASSWORD', 'user_password');

date_default_timezone_set('Europe/Rome');

$options = [
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASSWORD, $options);
} catch (PDOException $e) {
    die("Errore di connessione al database: " . $e->getMessage());
}

?>
