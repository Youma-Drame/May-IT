<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Connexion</title>
</head>
<body>
    

<h2>Connexion</h2>

<form method="POST">
    <a href="vue/home.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="mdp" placeholder="Mot de passe" required><br><br>

    <label>Je suis :</label><br>
    <select name="role" required>
        <option value="">-- Choisir --</option>
        <option value="candidat">Candidat</option>
        <option value="moniteur">Moniteur</option>
        <option value="admin">Administrateur</option>
    </select><br><br>

    <button type="submit">Connexion</button>
</form>

<?php if (isset($erreur)) echo "<p style='color:red'>$erreur</p>"; ?>
</body>
</html>