<?php
session_start();
$_SESSION = [];
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Redirection automatique vers main.php après 3 secondes -->
    <meta http-equiv="refresh" content="3;url=main.php">
    <title>Déconnexion - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>🍔 Food Express</header>

    <div class="container">
        <div class="logout-card">
            <h2 style="text-transform: uppercase;">Vous êtes déconnecté</h2>

            <div class="loader">👋</div>

            <p style="color: #555; font-size: 14px; margin-bottom: 10px;">
                Merci de votre visite ! Votre session a bien été fermée.
            </p>

            <p style="font-size: 13px; color: #888;">
                Redirection automatique vers l'accueil dans quelques secondes...
            </p>

            <a href="main.php" class="btn btn-blue">Retourner à l'accueil immédiatement</a>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - À bientôt !
    </footer>

</body>
</html>
