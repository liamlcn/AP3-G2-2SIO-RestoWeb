<?php
/**
 * Connexion à la base de données "apresto"
 * A inclure (require) dans toutes les pages ayant besoin de la BDD.
 */

$host     = "localhost";
$dbname   = "apresto";
$dbUser   = "root";   // à adapter selon votre configuration (WAMP/XAMPP/hébergeur...)
$dbPass   = "";       // à adapter selon votre configuration

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbUser,
        $dbPass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
