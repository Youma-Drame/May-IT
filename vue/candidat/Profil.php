<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6366f1;
            text-decoration: none;
            margin-bottom: 30px;
            font-weight: 500;
        }
        h1 { color: #1f2937; margin-bottom: 30px; }
        .success { background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .profile-info { background: #f9fafb; padding: 24px; border-radius: 12px; margin-bottom: 20px; }
        .info-row { display: flex; margin-bottom: 12px; }
        .info-label { font-weight: 600; width: 180px; color: #6b7280; }
        .info-value { color: #1f2937; }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            margin-right: 10px;
            transition: all 0.3s;
        }
        .btn-primary { background: #6366f1; color: white; }
        .btn-primary:hover { background: #4f46e5; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }
        #edit-mode { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php?page=candidat" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <h1>Mon Profil</h1>

        <?php if (isset($_GET['success'])): ?>
            <div class="success">✓ Profil mis à jour avec succès !</div>
        <?php endif; ?>

        <!-- Mode Lecture -->
        <div id="view-mode">
            <div class="profile-info">
                <div class="info-row">
                    <span class="info-label">Nom :</span>
                    <span class="info-value"><?= htmlspecialchars($candidatActuel['nom']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Prénom :</span>
                    <span class="info-value"><?= htmlspecialchars($candidatActuel['prenom']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email :</span>
                    <span class="info-value"><?= htmlspecialchars($candidatActuel['email']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de naissance :</span>
                    <span class="info-value"><?= $candidatActuel['datenaissance'] ?? 'Non renseignée' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Statut :</span>
                    <span class="info-value"><?= $candidatActuel['etudiant'] ? '🎓 Étudiant' : 'Non étudiant' ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Formule :</span>
                    <span class="info-value"><?= htmlspecialchars($formule['libelle']) ?> - <?= $formule['prix'] ?>€</span>
                </div>
            </div>

            <button class="btn btn-primary" onclick="toggleEditMode()">
                <i class="fas fa-edit"></i> Modifier mon profil
            </button>
        </div>

        <!-- Mode Édition -->
        <div id="edit-mode">
            <form method="POST" action="index.php?page=update-candidat">
                <div class="form-group">
                    <label>Nom :</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($candidatActuel['nom']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Prénom :</label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($candidatActuel['prenom']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email :</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($candidatActuel['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Date de naissance :</label>
                    <input type="date" name="datenaissance" value="<?= $candidatActuel['datenaissance'] ?>">
                </div>
                <div class="form-group">
                    <label>Formule :</label>
                    <select name="idformule" required>
                        <?php
                        $formules = $this->pdo->query("SELECT * FROM formule")->fetchAll();
                        foreach ($formules as $f) {
                            $selected = ($f['idformule'] == $candidatActuel['idformule']) ? 'selected' : '';
                            echo "<option value='{$f['idformule']}' {$selected}>{$f['libelle']} - {$f['prix']}€</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
                    <input type="password" name="mdp" placeholder="Nouveau mot de passe">
                </div>

                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Annuler</button>
            </form>
        </div>
    </div>

    <script>
        function toggleEditMode() {
            const viewMode = document.getElementById('view-mode');
            const editMode = document.getElementById('edit-mode');
            
            if (viewMode.style.display === 'none') {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
            } else {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
            }
        }
    </script>
</body>
</html>