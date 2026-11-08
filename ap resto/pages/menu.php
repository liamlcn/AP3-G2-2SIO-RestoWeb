<?php
require "../function_db/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ajout d'un produit au panier (envoyé par le formulaire de chaque carte produit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_panier'])) {
    $idProd   = (int) ($_POST['idPROD'] ?? 0);
    $quantite = (int) ($_POST['quantite'] ?? 1);
    if ($quantite < 1) {
        $quantite = 1;
    }

    if ($idProd > 0) {
        $_SESSION['panier'][$idProd] = ($_SESSION['panier'][$idProd] ?? 0) + $quantite;
    }

    // On redirige (pattern PRG) pour éviter le renvoi du formulaire au rechargement
    header("Location: menu.php");
    exit;
}

// Récupération des produits depuis la base de données
$stmt = $pdo->query("SELECT * FROM produit");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nombre total d'articles dans le panier (somme des quantités, pas juste le nombre de produits différents)
$nbArticles = isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0;

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
                            $id = (int) $row['idPROD'];

                            echo "<form method='post' class='product-card'>";
                                echo "<input type='hidden' name='ajouter_panier' value='1'>";
                                echo "<input type='hidden' name='idPROD' value='{$id}'>";
                                echo "<div>";
                                    echo "<div class='product-title'>".htmlspecialchars($row["libellePROD"])."</div>";
                                    echo "<div class='product-price'>".number_format($row["prixHT"], 2, ',', ' ')." €</div>";
                                echo "</div>";
                                echo "<div>";
                                    echo "<div class='qty-controls'>";
                                        echo "<button type='button' class='qty-btn' onclick='changerQuantite(this, -1)'>-</button>";
                                        echo "<input type='text' name='quantite' class='qty-input' value='1' readonly>";
                                        echo "<button type='button' class='qty-btn' onclick='changerQuantite(this, 1)'>+</button>";
                                    echo "</div>";
                                    echo "<button type='submit' class='btn btn-blue' style='width: 100%;'>Ajouter au panier</button>";
                                echo "</div>";
                            echo "</form>";

                        }
                    } else {
                        echo "<p>Aucun produit disponible pour le moment.</p>";
                    }
            
                ?>

            </div>

        </div>

        <script>
            // Incrémente/décrémente la quantité affichée dans la carte produit
            // avant l'envoi du formulaire "Ajouter au panier"
            function changerQuantite(bouton, delta) {
                const carte = bouton.closest('.product-card');
                const input = carte.querySelector('.qty-input');
                let valeur = parseInt(input.value, 10) || 1;
                valeur += delta;
                if (valeur < 1) {
                    valeur = 1;
                }
                input.value = valeur;
            }
        </script>

    </body>

    <footer>
                © 2026 Food Express - Application de commande en ligne
    </footer>
</html>