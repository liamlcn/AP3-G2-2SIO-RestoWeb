<?php
session_start();
$estConnecte = isset($_SESSION['idUTIL']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <div class="nav-buttons">
            <?php if ($estConnecte): ?>
                <span style="align-self: center; margin-right: 10px;">👋 <?= htmlspecialchars($_SESSION['loginUtil']) ?></span>
                <a href="deconnexion.php" class="btn btn-outline">Se déconnecter</a>
            <?php else: ?>
                <a href="connexion.php" class="btn btn-blue">Se connecter</a>
                <a href="inscription.php" class="btn btn-green">S'inscrire</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container">

        <div class="hero-card">
            <h1>Commandez votre repas en quelques clics</h1>
            <p>Choisissez vos produits favoris, indiquez votre mode de retrait et payez en toute sécurité.</p>

            <div class="badge-container">
                <span class="badge">🍽️ Sur Place</span>
                <span class="badge">🛍️ À Emporter</span>
                <span class="badge">💳 Paiement CB rapide</span>
            </div>

            <a href="menu.php" class="btn btn-green" style="font-size: 16px; padding: 12px 30px;">
                Voir la carte & Commander ➔
            </a>
        </div>

        <div class="grid-options">

            <?php if (!$estConnecte): ?>
                <div class="option-card">
                    <div>
                        <h3>Vous avez déjà un compte ?</h3>
                        <p>Connectez-vous pour passer votre commande plus rapidement et suivre l'avancement de votre préparation.</p>
                    </div>
                    <a href="connexion.php" class="btn btn-blue">Espace Connexion</a>
                </div>
            <?php else: ?>
                <div class="option-card">
                    <div>
                        <h3>Content de vous revoir !</h3>
                        <p>Accédez directement à la carte pour passer une nouvelle commande.</p>
                    </div>
                    <a href="menu.php" class="btn btn-blue">Commander maintenant</a>
                </div>
            <?php endif; ?>

            <div class="option-card">
                <div>
                    <h3>Espace Personnel / Admin</h3>
                    <p>Accès réservé au personnel du restaurant pour la gestion, la validation et la notification des commandes.</p>
                </div>
                <a href="adm_dashboard.php" class="btn btn-outline">Gestion Commandes (Staff)</a>
            </div>

        </div>

        <div class="info-box">
            <p>🔔 Un e-mail de confirmation vous sera envoyé dès que votre commande sera prête !</p>
            <span style="font-size: 20px;">✉️</span>
        </div>

    </div>

    <footer>
        &copy; 2026 Food Express - Application de commande en ligne | Tous droits réservés
    </footer>

</body>
</html>
