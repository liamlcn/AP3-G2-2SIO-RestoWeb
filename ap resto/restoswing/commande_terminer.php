<?php
/**
 * GET /api/commande_terminer.php?id_commande=XX
 *
 * Fait passer une commande de l'état "en_preparation" à "prete".
 * Erreurs silencieuses, conformément au cahier des charges.
 */

require "../function_db/db.php";

$idCommande = isset($_GET['id_commande']) ? (int) $_GET['id_commande'] : 0;

try {
    if ($idCommande > 0) {
        $stmt = $pdo->prepare("
            UPDATE commande
            SET etatCOM = 'prete'
            WHERE idCOM = :id AND etatCOM = 'en_preparation'
        ");
        $stmt->execute(['id' => $idCommande]);
    }
} catch (Exception $e) {
    // Erreur silencieuse, conformément au cahier des charges.
}