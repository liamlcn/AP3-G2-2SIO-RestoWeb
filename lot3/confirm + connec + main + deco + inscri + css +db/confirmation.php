<?php
session_start();
require "db.php";

// L'utilisateur doit être connecté pour voir une confirmation de commande
if (!isset($_SESSION['idUTIL'])) {
    header("Location: connexion.php");
    exit;
}

// L'id de commande peut arriver en GET (?id=12) juste après le paiement,
// ou être repris de la session si la page est revisitée.
$idCommande = isset($_GET['id']) ? (int) $_GET['id'] : ($_SESSION['dernier_idCOM'] ?? null);

if (!$idCommande) {
    header("Location: main.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT c.idCOM, c.etatCOM, c.date_horaireCOM, c.valeurTTC, c.typeCOM,
           u.loginUtil, u.emailUtil
    FROM commande c
    JOIN utilisateur u ON u.idUTIL = c.idUTIL
    WHERE c.idCOM = :idCom AND c.idUTIL = :idUtil
");
$stmt->execute([
    'idCom'  => $idCommande,
    'idUtil' => $_SESSION['idUTIL']
]);
$commande = $stmt->fetch();

// Commande introuvable ou n'appartenant pas à l'utilisateur connecté
if (!$commande) {
    header("Location: main.php");
    exit;
}

$_SESSION['dernier_idCOM'] = $commande['idCOM'];

// Correspondance état en BDD -> libellé + classe CSS affichés
$etats = [
    'en_attente' => ['libelle' => "⏳ Statut : En attente d'acceptation par le restaurant...", 'classe' => 'badge-status'],
    'acceptee'   => ['libelle' => "✅ Statut : Commande acceptée, en préparation",             'classe' => 'badge-status badge-success'],
    'refusee'    => ['libelle' => "❌ Statut : Commande refusée par le restaurant",             'classe' => 'badge-status badge-danger'],
    'prete'      => ['libelle' => "🍽️ Statut : Commande prête !",                              'classe' => 'badge-status badge-success'],
];
$etatInfo = $etats[$commande['etatCOM']] ?? [
    'libelle' => "Statut : " . htmlspecialchars($commande['etatCOM']),
    'classe'  => 'badge-status'
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>🍔 Food Express</header>

    <div class="container">
        <div class="status-card">
            <h1 style="color: #198754;">✅ Commande Validée !</h1>
            <p style="margin-top: 10px;">
                Merci <strong><?= htmlspecialchars($commande['loginUtil']) ?></strong>,
                votre paiement de <strong><?= number_format($commande['valeurTTC'], 2, ',', ' ') ?> € TTC</strong> a été accepté.
            </p>

            <div style="margin: 25px 0; border-top: 2px dashed #ccc; border-bottom: 2px dashed #ccc; padding: 15px 0;">
                <p><strong>N° de Commande :</strong> #CDE-<?= htmlspecialchars($commande['idCOM']) ?></p>
                <p><strong>Mode :</strong> <?= htmlspecialchars($commande['typeCOM']) ?></p>
                <p><strong>Date :</strong> <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($commande['date_horaireCOM']))) ?></p>
            </div>

            <div class="<?= htmlspecialchars($etatInfo['classe']) ?>">
                <?= $etatInfo['libelle'] ?>
            </div>

            <p style="font-size: 14px; color: #555;">📧 Un e-mail de notification vous sera envoyé dès que votre commande sera prête !</p>

            <a href="menu.php" class="btn btn-blue">Retour au menu</a>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Merci de votre confiance
    </footer>

</body>
</html>
