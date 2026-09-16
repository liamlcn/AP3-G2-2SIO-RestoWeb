<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Food Express</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #2b2b2b; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #000; }
        .logo { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        
        .btn { padding: 10px 20px; border: 2px solid #000; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; box-shadow: 2px 2px 0px #000; }
        .btn-green { background-color: #d1e7dd; color: #000; }
        .btn-outline { background-color: #fff; color: #000; }

        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; flex: 1; }
        .card { background-color: #fff; border: 2px solid #000; border-radius: 10px; padding: 25px; box-shadow: 3px 3px 0px #000; margin-bottom: 25px; }
        .card h3 { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; border-bottom: 2px solid #000; }

        .radio-group { display: flex; gap: 20px; margin: 15px 0; }
        .radio-option { display: flex; align-items: center; gap: 8px; font-weight: bold; cursor: pointer; }

        .totals { background-color: #f8f9fa; border: 2px dashed #000; padding: 15px; border-radius: 8px; text-align: right; margin-top: 15px; }
        .totals .final-price { font-size: 20px; font-weight: bold; color: #000; margin-top: 5px; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; font-size: 13px; }
        .form-control { width: 100%; padding: 10px; border: 2px solid #000; border-radius: 6px; font-size: 14px; }
        .form-row { display: flex; gap: 15px; }

        footer { text-align: center; padding: 20px; background-color: #ffffff; border-top: 2px solid #000; margin-top: 50px; font-size: 13px; color: #666; }
    </style>
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="menu.html" class="btn btn-outline">← Retour à la carte</a>
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
            <form action="confirmation.html">
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