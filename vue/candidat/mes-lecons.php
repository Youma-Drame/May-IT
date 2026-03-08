<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes leçons</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 40px 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
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
        .header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        .header h1 i { color: #6366f1; }
        .lecons-grid {
            display: grid;
            gap: 20px;
        }
        .lecon-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-left: 4px solid #6366f1;
        }
        .lecon-card.passed {
            border-left-color: #9ca3af;
            opacity: 0.7;
        }
        .lecon-date {
            font-size: 16px;
            font-weight: 600;
            color: #6366f1;
            margin-bottom: 12px;
        }
        .lecon-details {
            display: grid;
            gap: 10px;
        }
        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6b7280;
            font-size: 14px;
        }
        .detail-item i {
            color: #9ca3af;
            width: 20px;
        }
        .empty-state {
            background: white;
            padding: 80px 20px;
            border-radius: 16px;
            text-align: center;
            color: #9ca3af;
        }
        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php?page=candidat" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <div class="header">
            <h1>
                <i class="fas fa-calendar-alt"></i>
                Mes leçons de conduite
            </h1>
            <p style="color: #6b7280;">Retrouvez toutes vos leçons passées et à venir</p>
        </div>

        <div class="lecons-grid">
            <?php if (empty($lecons)): ?>
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>Aucune leçon planifiée pour le moment</p>
                </div>
            <?php else: ?>
                <?php foreach ($lecons as $lecon): ?>
                    <?php 
                    $isPassed = strtotime($lecon['datefin']) < time();
                    ?>
                    <div class="lecon-card <?= $isPassed ? 'passed' : '' ?>">
                        <div class="lecon-date">
                            <i class="fas fa-clock"></i>
                            <?= date('d/m/Y à H:i', strtotime($lecon['datedebut'])) ?>
                            -
                            <?= date('H:i', strtotime($lecon['datefin'])) ?>
                            <?= $isPassed ? '(Terminée)' : '' ?>
                        </div>
                        <div class="lecon-details">
                            <div class="detail-item">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <strong>Moniteur:</strong> <?= htmlspecialchars($lecon['moniteur_prenom'] . ' ' . $lecon['moniteur_nom']) ?>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-car"></i>
                                <strong>Véhicule:</strong> <?= htmlspecialchars($lecon['marque'] . ' ' . $lecon['nommodele']) ?> (<?= $lecon['immatriculation'] ?>)
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>