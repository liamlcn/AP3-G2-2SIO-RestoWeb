<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="main.php" class="btn btn-outline">← Accueil</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Connexion</h2>
            <form action="menu.php">
                <div class="form-group">
                    <label for="login">Email / Identifiant *</label>
                    <input type="email" id="login" class="form-control" placeholder="exemple@mail.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-blue" style="width: 100%; font-size: 16px; margin-top: 10px;">Se connecter</button>
            </form>

            <div class="switch-link">
                Pas encore de compte ? <a href="inscription.html">S'inscrire</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Espace Client
    </footer>

</body>
</html>