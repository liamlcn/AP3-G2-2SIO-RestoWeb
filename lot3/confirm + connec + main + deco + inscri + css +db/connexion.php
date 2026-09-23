<?php
session_start();
require "db.php";

$erreur = "";
$loginSaisi = "";
$inscriptionOk = isset($_GET['inscription']) && $_GET['inscription'] === 'ok';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginSaisi = trim($_POST['login'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($loginSaisi === '' || $password === '') {
        $erreur = "Merci de remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT * FROM utilisateur WHERE emailUtil = :login OR loginUtil = :login"
        );
        $stmt->execute(['login' => $loginSaisi]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur && password_verify($password, $utilisateur['mdpUtil'])) {
            $_SESSION['idUTIL']    = $utilisateur['idUTIL'];
            $_SESSION['loginUtil'] = $utilisateur['loginUtil'];
            $_SESSION['emailUtil'] = $utilisateur['emailUtil'];

            header("Location: menu.php");
            exit;
        } else {
            $erreur = "Email/identifiant ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="main.php" class="btn btn-outline">← Accueil</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Connexion</h2>

            <?php if ($inscriptionOk): ?>
                <div class="alert alert-success">
                    Votre compte a bien été créé, vous pouvez vous connecter.
                </div>
            <?php endif; ?>

            <?php if ($erreur !== ''): ?>
                <div class="alert alert-error"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form action="connexion.php" method="post">
                <div class="form-group">
                    <label for="login">Email / Identifiant *</label>
                    <input type="text" id="login" name="login" class="form-control" placeholder="exemple@mail.com" value="<?= htmlspecialchars($loginSaisi) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-blue" style="width: 100%; font-size: 16px; margin-top: 10px;">Se connecter</button>
            </form>

            <div class="switch-link">
                Pas encore de compte ? <a href="inscription.php">S'inscrire</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Espace Client
    </footer>

</body>
</html>
