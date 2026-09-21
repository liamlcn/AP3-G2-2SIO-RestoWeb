<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="menu.php" class="btn btn-outline">← Retour à la carte</a>
    </header>

    <div class="container">
        <h2 style="margin-bottom: 20px;">Mon Panier & Règlement</h2>

        <!-- Récapitulatif Produit -->
        <div class="card">
            <h3>1. Contenu de la commande</h3>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Burger Gourmet</td>
                        <td>1</td>
                        <td>12.00 €</td>
                        <td>12.00 €</td>
                    </tr>
                    <tr>
                        <td>Frites Maison</td>
                        <td>1</td>
                        <td>4.00 €</td>
                        <td>4.00 €</td>
                    </tr>
                </tbody>
            </table>

            <h4>Mode de consommation :</h4>
            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="retrait" value="place" checked> Manger sur place
                </label>
                <label class="radio-option">
                    <input type="radio" name="retrait" value="emporter"> À emporter
                </label>
            </div>

            <div class="totals">
                <div>Total HT : 14.55 €</div>
                <div>TVA (10%) : 1.45 €</div>
                <div class="final-price">Total TTC : 16.00 €</div>
            </div>
        </div>

        <!-- Paiement CB -->
        <div class="card">
            <h3>2. Paiement par carte bancaire</h3>
            <form action="confirmation.php">
                <div class="form-group">
                    <label>Numéro de Carte Bancaire</label>
                    <input type="text" class="form-control" placeholder="1234 5678 9101 1121" required>
                </div>
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label>Date d'expiration</label>
                        <input type="text" class="form-control" placeholder="MM/AA" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Code CVC</label>
                        <input type="text" class="form-control" placeholder="123" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-green" style="width: 100%; font-size: 16px; margin-top: 10px;">Payer 16.00 € TTC</button>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Paiement 100% Sécurisé
    </footer>

</body>
</html>