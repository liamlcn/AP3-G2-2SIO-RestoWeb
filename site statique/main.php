<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Food Express</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f5f5f5;
            color: #1a1a1a;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #2b2b2b;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #000;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border: 2px solid #000000;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            box-shadow: 2px 2px 0px #000;
            transition: transform 0.1s;
        }

        .btn:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px #000;
        }

        .btn-blue {
            background-color: #d0e1fd;
            color: #000;
        }

        .btn-green {
            background-color: #d1e7dd;
            color: #000;
        }

        .btn-red {
            background-color: #f8d7da;
            color: #000;
        }

        .btn-outline {
            background-color: #ffffff;
            color: #000;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            flex: 1;
        }

        .hero-card {
            background-color: #ffffff;
            border: 2px solid #000;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 4px 4px 0px #000;
        }

        .hero-card h1 {
            font-size: 28px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .hero-card p {
            font-size: 16px;
            color: #4a4a4a;
            margin-bottom: 25px;
        }

        .hero-card .badge-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .badge {
            background-color: #e9ecef;
            border: 1px solid #000;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .grid-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .option-card {
            background-color: #ffffff;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 3px 3px 0px #000;
        }

        .option-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 8px;
        }

        .option-card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        .info-box {
            margin-top: 40px;
            background-color: #fff3cd;
            border: 2px solid #000;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .info-box p {
            font-size: 14px;
            font-weight: bold;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #ffffff;
            border-top: 2px solid #000;
            margin-top: 50px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <div class="nav-buttons">
            <a href="connexion.html" class="btn btn-blue">Se connecter</a>
            <a href="inscription.html" class="btn btn-green">S'inscrire</a>
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

            <a href="menu.html" class="btn btn-green" style="font-size: 16px; padding: 12px 30px;">
                Voir la carte & Commander ➔
            </a>
        </div>

        <div class="grid-options">
            
            <div class="option-card">
                <div>
                    <h3>Vous avez déjà un compte ?</h3>
                    <p>Connectez-vous pour passer votre commande plus rapidement et suivre l'avancement de votre préparation.</p>
                </div>
                <a href="connexion.html" class="btn btn-blue">Espace Connexion</a>
            </div>

            <div class="option-card">
                <div>
                    <h3>Espace Personnel / Admin</h3>
                    <p>Accès réservé au personnel du restaurant pour la gestion, la validation et la notification des commandes.</p>
                </div>
                <a href="admin-dashboard.html" class="btn btn-outline">Gestion Commandes (Staff)</a>
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