<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    


<h2>Inscription</h2>
<a href="vue/home.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
<form method="POST">
    <input type="text" name="nom" placeholder="Nom" required><br><br>
    <input type="text" name="prenom" placeholder="Prénom" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="mdp" placeholder="Mot de passe" required><br><br>

    <label>Je m'inscris comme :</label><br>
    <select name="role" id="role" required>
        <option value="">-- Choisir --</option>
        <option value="candidat">Candidat</option>
        <option value="moniteur">Moniteur</option>
    </select><br><br>

    <!-- Champs spécifiques aux candidats -->
    <div id="candidat-fields" style="display:none;">
        <label>
            <input type="checkbox" name="etudiant" value="1" id="etudiant-checkbox"> 
            Je suis étudiant (réduction de 10%)
        </label><br><br>

        <label>Formule :</label><br>
        <select name="idformule" id="idformule">
            <option value="">-- Choisir une formule --</option>
            <?php
            if (isset($pdo)) {
                $formules = $pdo->query("SELECT * FROM formule")->fetchAll();
                foreach ($formules as $f) {
                    echo "<option value='{$f['idformule']}' data-prix='{$f['prix']}'>";
                    echo "{$f['libelle']} - {$f['prix']}€ ({$f['duree']}h)";
                    echo "</option>";
                }
            }
            ?>
        </select><br>
        <p id="prix-final" style="font-weight:bold; color:green;"></p>
        <br>
    </div>

    <button type="submit">S'inscrire</button>
    <br>
    <a href="index.php?page=login">Déjà un compte ? Connectez-vous</a>
</form>

<script>
// Afficher/masquer les champs candidat selon le rôle
const roleSelect = document.getElementById('role');
const candidatFields = document.getElementById('candidat-fields');
const formuleSelect = document.getElementById('idformule');
const etudiantCheckbox = document.getElementById('etudiant-checkbox');
const prixFinalDiv = document.getElementById('prix-final');

roleSelect.addEventListener('change', function() {
    if (this.value === 'candidat') {
        candidatFields.style.display = 'block';
        formuleSelect.required = true;
    } else {
        candidatFields.style.display = 'none';
        formuleSelect.required = false;
        prixFinalDiv.innerHTML = '';
    }
});

// Calculer et afficher le prix avec réduction
function updatePrice() {
    const selectedOption = formuleSelect.options[formuleSelect.selectedIndex];
    if (selectedOption.value) {
        let price = parseFloat(selectedOption.dataset.prix);
        if (etudiantCheckbox.checked) {
            const reduction = price * 0.10;
            price = price - reduction;
            prixFinalDiv.innerHTML = `Prix avec réduction étudiant : ${price.toFixed(2)}€ <small>(réduction de ${reduction.toFixed(2)}€)</small>`;
        } else {
            prixFinalDiv.innerHTML = `Prix : ${price.toFixed(2)}€`;
        }
    } else {
        prixFinalDiv.innerHTML = '';
    }
}

formuleSelect.addEventListener('change', updatePrice);
etudiantCheckbox.addEventListener('change', updatePrice);
</script>
</body>
</html>