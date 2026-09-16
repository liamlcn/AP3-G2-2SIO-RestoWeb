<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Food Express</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #2b2b2b; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #000; }
        .logo { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        
        .btn { padding: 10px 20px; border: 2px solid #000; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; box-shadow: 2px 2px 0px #000; transition: transform 0.1s; }
        .btn:active { transform: translate(2px, 2px); box-shadow: 0px 0px 0px #000; }
        .btn-blue { background-color: #d0e1fd; color: #000; }
        .btn-outline { background-color: #fff; color: #000; }

        .container { max-width: 450px; margin: 60px auto; padding: 0 20px; flex: 1; width: 100%; }
        .card { background-color: #fff; border: 2px solid #000; border-radius: 12px; padding: 30px; box-shadow: 4px 4px 0px #000; }
        .card h2 { text-align: center; text-transform: uppercase; margin-bottom: 25px; border-bottom: 2px solid #000; padding-bottom: 10px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 12px; border: 2px solid #000; border-radius: 8px; font-size: 14px; background-color: #fafafa; }
        
        .switch-link { text-align: center; margin-top: 20px; font-size: 13px; }
        .switch-link a { color: #000; font-weight: bold; text-decoration: underline; }

        footer { text-align: center; padding: 20px; background-color: #ffffff; border-top: 2px solid #000; font-size: 13px; color: #666; }
    </style>
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