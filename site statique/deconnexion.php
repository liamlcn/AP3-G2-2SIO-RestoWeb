<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Redirection automatique vers index.html après 3 secondes -->
    <meta http-equiv="refresh" content="3;url=main.php">
    <title>Déconnexion - Food Express</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #2b2b2b; color: white; padding: 15px 30px; text-align: center; border-bottom: 3px solid #000; font-size: 20px; font-weight: bold; }
        
        .container { max-width: 500px; margin: 80px auto; padding: 0 20px; flex: 1; text-align: center; }
        .logout-card { background-color: #fff; border: 2px solid #000; border-radius: 12px; padding: 40px; box-shadow: 4px 4px 0px #000; }
        
        .loader { font-size: 40px; margin: 20px 0; }

        .btn { padding: 10px 20px; border: 2px solid #000; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 15px; box-shadow: 2px 2px 0px #000; }
        .btn-blue { background-color: #d0e1fd; color: #000; }

        footer { text-align: center; padding: 20px; background-color: #ffffff; border-top: 2px solid #000; font-size: 13px; color: #666; }
    </style>
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