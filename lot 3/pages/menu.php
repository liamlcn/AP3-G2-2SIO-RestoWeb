<?php
require "../function_db/db.php";

// Récupération des produits depuis la base de données
$stmt = $pdo->query("SELECT * FROM produit");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gestion du nombre d'articles dans le panier (ex: stocké en session)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nbArticles = isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0;

?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Carte & Menu - Food Express</title>

        <link rel="stylesheet" href="../css/maincss.css">
    </head>

    <body>

        <header>
            <div class="logo">🍔 Food Express</div>
            <div class="user-info">
                <span>Bienvenue, <strong>M le prof</strong></span>

                <a href="../main.php" class="btn btn-red">Se déconnecter</a>
            </div>
        </header>

        <div class="container">
            <div class="top-bar">
                <h2>Nos Produits</h2>
                <a href="panier.php" class="btn btn-green" style="font-size: 16px;">🛒 Voir le Panier (<?php echo $nbArticles; ?> articles)</a>
            </div>

            <div class="product-grid">
 
                <?php

                    if (!empty($rows)) {
                        foreach($rows as $row) {

                            echo "<div class='product-card'>";
                                echo "<div>";
                                    echo "<div class='product-title'>".$row["libellePROD"]."</div>";
                                    echo "<div class='product-price'>".$row["prixHT"]." €</div>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<div class='qty-controls'>";
                                        echo "<button class='qty-btn'>-</button>";
                                        echo "<input type='text' class='qty-input' value='1' readonly>";
                                        echo "<button class='qty-btn'>+</button>";
                                    echo "</div>";
                                    echo "<button class='btn btn-blue' style='width: 100%;'>Ajouter au panier</button>";
                                echo "</div>";
                            echo "</div>";

                        }
                    } else {
                        echo "<p>Aucun produit disponible pour le moment.</p>";
                    }
            
                ?>

            </div>

    </body>

    <footer>
                © 2026 Food Express - Application de commande en ligne
    </footer>
</html>