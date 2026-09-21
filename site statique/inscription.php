<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="main.php" class="btn btn-outline">← Accueil</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Inscription</h2>
            <form action="connexion.html">
                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" class="form-control" placeholder="Antoine" required>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" class="form-control" placeholder="Dupont" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail *</label>
                    <input type="email" id="email" class="form-control" placeholder="jean.dupont@email.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe *</label>
                    <input type="password" id="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-green" style="width: 100%; font-size: 16px; margin-top: 10px;">S'inscrire</button>
            </form>

            <div class="switch-link">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Création de compte
    </footer>

</body>
</html>