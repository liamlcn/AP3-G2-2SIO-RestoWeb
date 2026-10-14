<?php
/**
 * GET /api/commandes_en_attente.php
 *
 * Retourne la liste des commandes payées mais non encore servies
 * (etatCOM = 'en_attente'), au format JSON, pour RestoSwing.
 *
 * Réponse : tableau JSON (vide si aucune commande en attente).
 * Erreur : réponse silencieuse (tableau vide), conformément au cahier des charges.
 */

header('Content-Type: application/json; charset=utf-8');
require "../function_db/db.php";

try {
    $stmt = $pdo->prepare("
        SELECT c.idCOM, c.date_horaireCOM, c.valeurTTC, c.typeCOM, c.TVA, u.loginUtil
        FROM commande c
        JOIN utilisateur u ON u.idUTIL = c.idUTIL
        WHERE c.etatCOM = 'en_attente'
        ORDER BY c.date_horaireCOM ASC
    ");
    $stmt->execute();
    $commandes = $stmt->fetchAll();

    $stmtLignes = $pdo->prepare("
        SELECT p.libellePROD, l.quantiteProduit, l.totalHT
        FROM ligne_de_commande l
        JOIN produit p ON p.idPROD = l.idPROD
        WHERE l.idCOM = :idCom
    ");

    $resultat = [];
    foreach ($commandes as $commande) {
        $stmtLignes->execute(['idCom' => $commande['idCOM']]);
        $lignes = $stmtLignes->fetchAll();

        $produits = [];
        foreach ($lignes as $ligne) {
            $produits[] = [
                'libelle'  => $ligne['libellePROD'],
                'quantite' => (int) $ligne['quantiteProduit'],
                'total_ht' => (float) $ligne['totalHT'],
            ];
        }

        $resultat[] = [
            'id_commande' => (int) $commande['idCOM'],
            'date_heure'  => $commande['date_horaireCOM'],
            'montant_ttc' => (float) $commande['valeurTTC'],
            'tva'         => (float) $commande['TVA'],
            'mode'        => $commande['typeCOM'],
            'client'      => $commande['loginUtil'],
            'produits'    => $produits,
        ];
    }

    echo json_encode($resultat, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // Erreur silencieuse : le cahier des charges interdit tout message d'erreur visible.
    http_response_code(200);
    echo json_encode([]);
}
