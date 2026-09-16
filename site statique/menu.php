<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte & Menu - Food Express</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0; }
        body { background-color: #f5f5f5; color: #1a1a1a; min-height: 100vh; display: flex; flex-direction: column; }
        header { background-color: #2b2b2b; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #000; }
        .logo { font-size: 20px; font-weight: bold; text-transform: uppercase; }
        .user-info { display: flex; align-items: center; gap: 15px; font-size: 14px; }
        
        .btn { padding: 8px 16px; border: 2px solid #000; border-radius: 8px; font-weight: bold; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; box-shadow: 2px 2px 0px #000; transition: transform 0.1s; }
        .btn:active { transform: translate(2px, 2px); box-shadow: 0px 0px 0px #000; }
        .btn-red { background-color: #f8d7da; color: #000; }
        .btn-green { background-color: #d1e7dd; color: #000; }
        .btn-blue { background-color: #d0e1fd; color: #000; }

        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; flex: 1; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        .product-card { background-color: #fff; border: 2px solid #000; border-radius: 10px; padding: 20px; box-shadow: 3px 3px 0px #000; display: flex; flex-direction: column; justify-content: space-between; }
        .product-img { width: 100%; height: 140px; background-color: #eee; border: 2px solid #000; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 15px; }
        .product-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .product-desc { font-size: 13px; color: #555; margin-bottom: 15px; }
        .product-price { font-size: 16px; font-weight: bold; margin-bottom: 15px; }
        
        .qty-controls { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        .qty-btn { width: 32px; height: 32px; border: 2px solid #000; background: #fff; font-weight: bold; font-size: 16px; cursor: pointer; border-radius: 6px; box-shadow: 1px 1px 0px #000; }
        .qty-input { width: 45px; height: 32px; text-align: center; border: 2px solid #000; border-radius: 6px; font-weight: bold; }
        
        footer { text-align: center; padding: 20px; background-color: #ffffff; border-top: 2px solid #000; margin-top: 50px; font-size: 13px; color: #666; }
    </style>
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <div class="user-info">
            <span>Bienvenue, <strong>Jean Dupont</strong></span>
            <a href="index.html" class="btn btn-red">Se déconnecter</a>
        </div>
    </header>

    <div class="container">
        <div class="top-bar">
            <h2>Nos Produits</h2>
            <a href="panier.html" class="btn btn-green" style="font-size: 16px;">🛒 Voir le Panier (3 articles)</a>
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