<?php

    //include "db_functions.php";

    function db_connect() {
        $dsn = 'mysql:host=localhost;dbname=AP3_resto';  // contient le nom du serveur et de la base
        $user = 'root';
        $password = '';
        try {
            $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    
        catch (PDOException $ex) {
            die("Erreur lors de la connexion SQL : " . $ex->getMessage());
        }

        return $dbh;
    }

    $dbh = db_connect();

    $sql = "SELECT *
    FROM produit";
    
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    
    catch (PDOException $e) {
        die("<p>Erreur lors de la requête SQL : " . $e->getMessage() . "</p>");
    }

?>

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
                <span>Bienvenue, <strong>M le prof</strong></span>

                <a href="main.php" class="btn btn-red">Se déconnecter</a>
            </div>
        </header>

        <div class="container">
            <div class="top-bar">
                <h2>Nos Produits</h2>
                <a href="panier.php" class="btn btn-green" style="font-size: 16px;">🛒 Voir le Panier (<?php echo count($rows)?> articles)</a>
            </div>

            <div class="product-grid">

                <!-- Produit 1
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
                </div> -->

                <?php

                    foreach($rows as $row){

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
            
                ?>

            </div>

            <footer>
                &copy; 2026 Food Express - Application de commande en ligne
            </footer>

    </body>

</html>