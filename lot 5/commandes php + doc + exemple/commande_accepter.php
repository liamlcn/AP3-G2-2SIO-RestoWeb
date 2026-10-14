<?php
/**
 * GET /api/commande_accepter.php?id_commande=XX
 *
 * Fait passer une commande de l'état "en_attente" à "en_preparation".
 * Aucune réponse n'est requise par le cahier des charges ; les erreurs
 * (id manquant, commande inexistante, mauvais état...) sont silencieuses.
 */

require "../function_db/db.php";

$idCommande = isset($_GET['id_commande']) ? (int) $_GET['id_commande'] : 0;

try {
    if ($idCommande > 0) {
        $stmt = $pdo->prepare("
            UPDATE commande
            SET etatCOM = 'en_preparation'
            WHERE idCOM = :id AND etatCOM = 'en_attente'
        ");
        $stmt->execute(['id' => $idCommande]);
    }
} catch (Exception $e) {
    // Erreur silencieuse, conformément au cahier des charges.
}