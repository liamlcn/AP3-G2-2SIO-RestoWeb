<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Food Express</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #2b2b2b; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #000; }
        .logo { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        
        .btn { padding: 10px 20px; border: 2px solid #000; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; box-shadow: 2px 2px 0px #000; transition: transform 0.1s; }
        .btn:active { transform: translate(2px, 2px); box-shadow: 0px 0px 0px #000; }
        .btn-green { background-color: #d1e7dd; color: #000; }
        .btn-outline { background-color: #fff; color: #000; }

        .container { max-width: 500px; margin: 40px auto; padding: 0 20px; flex: 1; width: 100%; }
        .card { background-color: #fff; border: 2px solid #000; border-radius: 12px; padding: 30px; box-shadow: 4px 4px 0px #000; }
        .card h2 { text-align: center; text-transform: uppercase; margin-bottom: 25px; border-bottom: 2px solid #000; padding-bottom: 10px; }

        .form-row { display: flex; gap: 15px; }
        .form-group { margin-bottom: 15px; flex: 1; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 6px; font-size: 13px; }
        .form-control { width: 100%; padding: 10px; border: 2px solid #000; border-radius: 8px; font-size: 14px; background-color: #fafafa; }
        
        .switch-link { text-align: center; margin-top: 20px; font-size: 13px; }
        .switch-link a { color: #000; font-weight: bold; text-decoration: underline; }

        footer { text-align: center; padding: 20px; background-color: #ffffff; border-top: 2px solid #000; font-size: 13px; color: #666; }
    </style>
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="index.html" class="btn btn-outline">← Accueil</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Inscription</h2>
            <form action="connexion.html">
                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" class="form-control" placeholder="Jean" required>
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
                Déjà un compte ? <a href="connexion.html">Se connecter</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Création de compte
    </footer>

</body>
</html>