<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte & Menu - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <div class="user-info">
            <span>Bienvenue, <strong>Jean Dupont</strong></span>
            <a href="main.php" class="btn btn-red">Se déconnecter</a>
        </div>
    </header>

    <div class="container">
        <div class="top-bar">
            <h2>Nos Produits</h2>
            <a href="panier.php" class="btn btn-green" style="font-size: 16px;">🛒 Voir le Panier (3 articles)</a>
        </div>

        <div class="product-grid">
            <!-- Produit 1 -->
            <div class="product-card">
                <div>
                    <div class="product-img">🍔</div>
                    <div class="product-title">Burger Gourmet</div>
                    <div class="product-desc">Pain brioché, steak haché 150g, fromage cheddar, sauce maison.</div>
                    <div class="product-price">12.00 € TTC</div>
                </div>
                <div>
                    <div class="qty-controls">
                        <button class="qty-btn">-</button>
                        <input type="text" class="qty-input" value="1" readonly>
                        <button class="qty-btn">+</button>
                    </div>
                    <button class="btn btn-blue" style="width: 100%;">Ajouter au panier</button>
                </div>
            </div>

            <!-- Produit 2 -->
            <div class="product-card">
                <div>
                    <div class="product-img">🍟</div>
                    <div class="product-title">Frites Maison</div>
                    <div class="product-desc">Frites fraîches coupées à la main et cuites en deux bains.</div>
                    <div class="product-price">4.00 € TTC</div>
                </div>
                <div>
                    <div class="qty-controls">
                        <button class="qty-btn">-</button>
                        <input type="text" class="qty-input" value="1" readonly>
                        <button class="qty-btn">+</button>
                    </div>
                    <button class="btn btn-blue" style="width: 100%;">Ajouter au panier</button>
                </div>
            </div>

            <!-- Produit 3 -->
            <div class="product-card">
                <div>
                    <div class="product-img">🥤</div>
                    <div class="product-title">Boisson Soda (33cl)</div>
                    <div class="product-desc">Au choix : Coca-Cola, Ice Tea, Eau gazeuse.</div>
                    <div class="product-price">2.50 € TTC</div>
                </div>
                <div>
                    <div class="qty-controls">
                        <button class="qty-btn">-</button>
                        <input type="text" class="qty-input" value="1" readonly>
                        <button class="qty-btn">+</button>
                    </div>
                    <button class="btn btn-blue" style="width: 100%;">Ajouter au panier</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Application de commande en ligne
    </footer>

</body>
</html>