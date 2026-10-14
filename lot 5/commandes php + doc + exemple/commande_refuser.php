<?php
/**
 * GET /api/commande_refuser.php?id_commande=XX
 *
 * Fait passer une commande à l'état "abandonnee" (plus d'ingrédient,
 * trop de travail, panne, fermeture...). Autorisé depuis "en_attente"
 * ou "en_preparation" (un refus peut arriver après le début de préparation).
 * Erreurs silencieuses, conformément au cahier des charges.
 */

require "../function_db/db.php";

$idCommande = isset($_GET['id_commande']) ? (int) $_GET['id_commande'] : 0;

try {
    if ($idCommande > 0) {
        $stmt = $pdo->prepare("
            UPDATE commande
            SET etatCOM = 'abandonnee'
            WHERE idCOM = :id AND etatCOM IN ('en_attente', 'en_preparation')
        ");
        $stmt->execute(['id' => $idCommande]);
    }
} catch (Exception $e) {
    // Erreur silencieuse, conformément au cahier des charges.
}