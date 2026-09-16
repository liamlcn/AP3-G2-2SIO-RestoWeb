<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - Food Express</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #2b2b2b; color: white; padding: 15px 30px; text-align: center; border-bottom: 3px solid #000; font-size: 20px; font-weight: bold; }
        
        .container { max-width: 600px; margin: 50px auto; padding: 0 20px; flex: 1; text-align: center; }
        .status-card { background-color: #fff; border: 2px solid #000; border-radius: 12px; padding: 40px; box-shadow: 4px 4px 0px #000; }
        
        .badge-status { display: inline-block; background-color: #fff3cd; border: 2px solid #000; padding: 10px 20px; border-radius: 20px; font-weight: bold; margin: 20px 0; }
        
        .btn { padding: 10px 20px; border: 2px solid #000; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 20px; box-shadow: 2px 2px 0px #000; }
        .btn-blue { background-color: #d0e1fd; color: #000; }

        footer { text-align: center; padding: 20px; background-color: #ffffff; border-top: 2px solid #000; font-size: 13px; color: #666; }
    </style>
</head>
<body>

    <header>🍔 Food Express</header>

    <div class="container">
        <div class="status-card">
            <h1 style="color: #198754;">✅ Commande Validée !</h1>
            <p style="margin-top: 10px;">Merci <strong>Jean Dupont</strong>, votre paiement de <strong>16.00 € TTC</strong> a été accepté.</p>
            
            <div style="margin: 25px 0; border-top: 2px dashed #ccc; border-bottom: 2px dashed #ccc; padding: 15px 0;">
                <p><strong>N° de Commande :</strong> #CDE-101</p>
                <p><strong>Mode :</strong> Manger sur place</p>
            </div>

            <div class="badge-status">
                ⏳ Statut : En attente d'acceptation par le restaurant...
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