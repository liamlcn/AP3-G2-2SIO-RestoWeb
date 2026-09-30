<?php
session_start();
require "../function_db/db.php";

// Le panier doit être connecté pour valider une commande
if (!isset($_SESSION['idUTIL'])) {
    header("Location: connexion.php");
    exit;
}

// Le panier est stocké en session sous la forme [idPROD => quantite, ...]
// (à remplir depuis menu.php quand l'utilisateur ajoute un produit)
$panier = $_SESSION['panier'] ?? [];

$erreurs = [];
$lignes = [];
$totalHT = 0.0;

// Taux de TVA restauration en France : 10% sur place, 5,5% à emporter
$tauxTVAParMode = [
    'place'    => 0.10,
    'emporter' => 0.055,
];

if (!empty($panier)) {
    // On récupère les produits réellement présents dans le panier
    $idsProduits = array_keys($panier);
    $placeholders = implode(',', array_fill(0, count($idsProduits), '?'));

    $stmt = $pdo->prepare("SELECT idPROD, libellePROD, prixHT FROM produit WHERE idPROD IN ($placeholders)");
    $stmt->execute($idsProduits);
    $produits = $stmt->fetchAll();

    foreach ($produits as $produit) {
        $quantite = (int) $panier[$produit['idPROD']];
        if ($quantite <= 0) {
            continue;
        }
        $totalLigneHT = $produit['prixHT'] * $quantite;
        $totalHT += $totalLigneHT;

        $lignes[] = [
            'idPROD'   => $produit['idPROD'],
            'libelle'  => $produit['libellePROD'],
            'prixHT'   => $produit['prixHT'],
            'quantite' => $quantite,
            'totalHT'  => $totalLigneHT,
        ];
    }
}

// On calcule les deux scénarios possibles (sur place / à emporter) pour pouvoir
// basculer l'affichage instantanément en JS quand l'utilisateur change de radio,
// sans avoir besoin de recharger la page.
$totauxParMode = [];
foreach ($tauxTVAParMode as $mode => $taux) {
    $tvaMode = $totalHT * $taux;
    $totauxParMode[$mode] = [
        'taux'     => $taux,
        'tva'      => $tvaMode,
        'totalTTC' => $totalHT + $tvaMode,
    ];
}

// Mode retenu par défaut à l'affichage (case "Manger sur place" cochée par défaut)
$modeParDefaut = 'place';

// Traitement du paiement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $retrait      = $_POST['retrait'] ?? 'place';
    $numeroCarte  = trim($_POST['numero_carte'] ?? '');
    $expiration   = trim($_POST['expiration'] ?? '');
    $cvc          = trim($_POST['cvc'] ?? '');

    // Sécurité : on ne fait jamais confiance au taux envoyé par le client,
    // on recalcule le bon taux/total côté serveur à partir du mode choisi.
    if (!isset($tauxTVAParMode[$retrait])) {
        $retrait = 'place';
    }
    $tauxTVA  = $tauxTVAParMode[$retrait];
    $tva      = $totalHT * $tauxTVA;
    $totalTTC = $totalHT + $tva;

    if (empty($lignes)) {
        $erreurs[] = "Votre panier est vide.";
    }
    if (!preg_match('/^[0-9 ]{13,23}$/', $numeroCarte)) {
        $erreurs[] = "Numéro de carte invalide.";
    }
    if (!preg_match('/^(0[1-9]|1[0-2])\/[0-9]{2}$/', $expiration)) {
        $erreurs[] = "Date d'expiration invalide (format MM/AA).";
    }
    if (!preg_match('/^[0-9]{3}$/', $cvc)) {
        $erreurs[] = "Code CVC invalide.";
    }

    // NB : il n'y a ici aucun vrai traitement bancaire (pas de connexion à un
    // établissement de paiement) : on simule l'acceptation du paiement une fois
    // le format des champs validé, et aucune donnée de carte n'est stockée.
    if (empty($erreurs)) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("
                INSERT INTO commande (etatCOM, date_horaireCOM, valeurTTC, typeCOM, TVA, idUTIL)
                VALUES ('en_attente', NOW(), :valeurTTC, :typeCOM, :tva, :idUtil)
            ");
            $stmt->execute([
                'valeurTTC' => $totalTTC,
                'typeCOM'   => $retrait === 'emporter' ? 'À emporter' : 'Manger sur place',
                'tva'       => $tauxTVA,
                'idUtil'    => $_SESSION['idUTIL'],
            ]);
            $idCommande = $pdo->lastInsertId();

            $stmtLigne = $pdo->prepare("
                INSERT INTO ligne_de_commande (quantiteProduit, totalHT, idCOM, idPROD)
                VALUES (:quantite, :totalHT, :idCom, :idProd)
            ");
            foreach ($lignes as $ligne) {
                $stmtLigne->execute([
                    'quantite' => $ligne['quantite'],
                    'totalHT'  => $ligne['totalHT'],
                    'idCom'    => $idCommande,
                    'idProd'   => $ligne['idPROD'],
                ]);
            }

            $pdo->commit();

            // Le panier est vidé une fois la commande enregistrée
            unset($_SESSION['panier']);
            $_SESSION['dernier_idCOM'] = $idCommande;

            header("Location: confirmation.php?id=" . $idCommande);
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            // --- DEBUG TEMPORAIRE : affiche le vrai message d'erreur, à retirer une fois corrigé ---
            $erreurs[] = "Erreur technique : " . $e->getMessage();
            // -----------------------------------------------------------------------------------
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Food Express</title>
    <link rel="stylesheet" href="../css/maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="menu.php" class="btn btn-outline">← Retour à la carte</a>
    </header>

    <div class="container">
        <h2 style="margin-bottom: 20px;">Mon Panier & Règlement</h2>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-error">
                <ul style="margin:0; padding-left: 18px;">
                    <?php foreach ($erreurs as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Récapitulatif Produit -->
        <div class="card">
            <h3>1. Contenu de la commande</h3>

            <?php if (empty($lignes)): ?>
                <p>Votre panier est vide. <a href="menu.php">Retourner à la carte</a>.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lignes as $ligne): ?>
                            <tr>
                                <td><?= htmlspecialchars($ligne['libelle']) ?></td>
                                <td><?= (int) $ligne['quantite'] ?></td>
                                <td><?= number_format($ligne['prixHT'], 2, ',', ' ') ?> €</td>
                                <td><?= number_format($ligne['totalHT'], 2, ',', ' ') ?> €</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h4>Mode de consommation :</h4>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="retrait" form="form-paiement" value="place" checked
                               onchange="majTotaux('place')"> Manger sur place
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="retrait" form="form-paiement" value="emporter"
                               onchange="majTotaux('emporter')"> À emporter
                    </label>
                </div>

                <div class="totals">
                    <div>Total HT : <span id="total-ht"><?= number_format($totalHT, 2, ',', ' ') ?></span> €</div>
                    <div>TVA (<span id="taux-tva"><?= $totauxParMode[$modeParDefaut]['taux'] * 100 ?></span>%) : <span id="total-tva"><?= number_format($totauxParMode[$modeParDefaut]['tva'], 2, ',', ' ') ?></span> €</div>
                    <div class="final-price">Total TTC : <span id="total-ttc"><?= number_format($totauxParMode[$modeParDefaut]['totalTTC'], 2, ',', ' ') ?></span> €</div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($lignes)): ?>
        <!-- Paiement CB -->
        <div class="card">
            <h3>2. Paiement par carte bancaire</h3>
            <form action="panier.php" method="post" id="form-paiement">
                <div class="form-group">
                    <label>Numéro de Carte Bancaire</label>
                    <input type="text" name="numero_carte" class="form-control" placeholder="1234 5678 9101 1121" required>
                </div>
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label>Date d'expiration</label>
                        <input type="text" name="expiration" class="form-control" placeholder="MM/AA" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Code CVC</label>
                        <input type="text" name="cvc" class="form-control" placeholder="123" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-green" style="width: 100%; font-size: 16px; margin-top: 10px;" id="btn-payer">
                    Payer <span id="btn-total-ttc"><?= number_format($totauxParMode[$modeParDefaut]['totalTTC'], 2, ',', ' ') ?></span> € TTC
                </button>
            </form>
        </div>

        <script>
            // Totaux pré-calculés côté serveur pour chaque mode (évite de refaire le calcul
            // en JS avec un risque d'arrondi différent de celui du serveur).
            const totauxParMode = <?= json_encode($totauxParMode, JSON_NUMERIC_CHECK) ?>;

            function formaterEuro(valeur) {
                return valeur.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function majTotaux(mode) {
                const donnees = totauxParMode[mode];
                if (!donnees) return;

                document.getElementById('taux-tva').textContent = (donnees.taux * 100).toString();
                document.getElementById('total-tva').textContent = formaterEuro(donnees.tva);
                document.getElementById('total-ttc').textContent = formaterEuro(donnees.totalTTC);
                document.getElementById('btn-total-ttc').textContent = formaterEuro(donnees.totalTTC);
            }
        </script>
        <?php endif; ?>
    </div>

    <footer>
        &copy; 2026 Food Express - Paiement 100% Sécurisé
    </footer>

</body>
</html>