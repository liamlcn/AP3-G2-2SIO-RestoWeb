<?php
session_start();
require "db.php";

$erreurs = [];
$prenom = $nom = $email = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom          = trim($_POST['prenom'] ?? '');
    $nom             = trim($_POST['nom'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($prenom === '' || $nom === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $erreurs[] = "Merci de remplir tous les champs.";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Adresse e-mail invalide.";
    }
    if ($password !== '' && strlen($password) < 6) {
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if ($password !== $confirmPassword) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("SELECT idUTIL FROM utilisateur WHERE emailUtil = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $erreurs[] = "Un compte existe déjà avec cette adresse e-mail.";
        }
    }

    if (empty($erreurs)) {
        // La table utilisateur ne possède pas de colonnes prénom/nom séparées :
        // on les combine dans loginUtil.
        $loginUtil = $prenom . " " . $nom;
        $mdpHash   = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare(
            "INSERT INTO utilisateur (emailUtil, loginUtil, mdpUtil) VALUES (:email, :login, :mdp)"
        );
        $stmt->execute([
            'email' => $email,
            'login' => $loginUtil,
            'mdp'   => $mdpHash
        ]);

        header("Location: connexion.php?inscription=ok");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Food Express</title>
    <link rel="stylesheet" href="maincss.css">
</head>
<body>

    <header>
        <div class="logo">🍔 Food Express</div>
        <a href="main.php" class="btn btn-outline">← Accueil</a>
    </header>

    <div class="container">
        <div class="card">
            <h2>Inscription</h2>

            <?php if (!empty($erreurs)): ?>
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left: 18px;">
                        <?php foreach ($erreurs as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="inscription.php" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Antoine" value="<?= htmlspecialchars($prenom) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Dupont" value="<?= htmlspecialchars($nom) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail *</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="jean.dupont@email.com" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer le mot de passe *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-green" style="width: 100%; font-size: 16px; margin-top: 10px;">S'inscrire</button>
            </form>

            <div class="switch-link">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2026 Food Express - Création de compte
    </footer>

</body>
</html>
