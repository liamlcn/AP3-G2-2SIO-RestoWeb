<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Commandes - Staff Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div style="font-size: 18px; font-weight: bold;">🛠️ GESTION COMMANDES (Staff)</div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <span style="font-size: 13px;">Connecté: <strong>Admin1 (Staff)</strong></span>
            <a href="index.html" class="btn btn-red">Déconnexion</a>
        </div>
    </header>

    <div class="container">

        <!-- 1. Commandes En Attente -->
        <div class="section-box">
            <div class="section-title">
                1. Commandes en Attente (Accepter / Refuser)
                <span style="background-color: #fff3cd; border: 1px solid #000; padding: 2px 10px; border-radius: 10px; font-size: 12px;">1 nouvelle</span>
            </div>

            <div class="order-card" style="background-color: #fff8e6;">
                <div class="order-details">
                    <strong>#CDE-101 | Jean Dupont</strong> (12:30) <span class="badge-type">Sur Place</span><br>
                    <span style="color: #555;">1x Burger Gourmet, 1x Frites Maison</span><br>
                    <strong style="color: #000;">Total TTC: 16.00 €</strong>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn btn-green">✔ Accepter</button>
                    <button class="btn btn-red">✖ Refuser</button>
                </div>
            </div>
        </div>

        <!-- 2. Commandes En Préparation -->
        <div class="section-box">
            <div class="section-title">2. En Préparation (Notifier le client par e-mail)</div>

            <div class="order-card">
                <div class="order-details">
                    <strong>#CDE-100 | Marie Curie</strong> (12:15) <span class="badge-type">À Emporter</span><br>
                    <span style="color: #555;">2x Soda 33cl, 2x Burger Gourmet</span><br>
                    <strong style="color: #000;">Total TTC: 29.00 €</strong>
                </div>
                <div>
                    <button class="btn btn-blue">✉️ Marquer Prête & Notifier Mail</button>
                </div>
            </div>
        </div>

        <!-- 3. Commandes Prêtes pour Retrait -->
        <div class="section-box">
            <div class="section-title">3. Commandes Prêtes (Confirmer le retrait)</div>

            <div class="order-card" style="background-color: #e8f5e9;">
                <div class="order-details">
                    <strong>#CDE-099 | Paul Martin</strong> (12:00) <span class="badge-type">À Emporter</span><br>
                    <span style="color: #555;">1x Frites Maison</span> — <em style="color: green;">Client notifié par mail</em>
                </div>
                <div>
                    <button class="btn btn-green">✅ Marquer comme Retirée</button>
                </div>
            </div>
        </div>

    </div>

    <footer>
        &copy; 2026 Food Express - Espace Administration
    </footer>

</body>
</html>