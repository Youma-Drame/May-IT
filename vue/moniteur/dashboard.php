<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Moniteur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .logo i {
            font-size: 32px;
            color: #f59e0b;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .logo-subtitle {
            font-size: 12px;
            color: #9ca3af;
        }

        .menu {
            flex: 1;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 18px;
            margin-bottom: 8px;
            border-radius: 10px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
        }

        .menu-item:hover {
            background: #f3f4f6;
            color: #f59e0b;
        }

        .menu-item.active {
            background: #f59e0b;
            color: white;
        }

        .menu-item i {
            width: 20px;
            font-size: 18px;
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            border-top: 1px solid #e5e7eb;
            margin-top: 20px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-info h4 {
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .user-info p {
            font-size: 12px;
            color: #9ca3af;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px 50px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 40px;
        }

        .greeting {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .greeting .wave {
            display: inline-block;
            animation: wave 2s infinite;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-20deg); }
        }

        .subtitle {
            color: #6b7280;
            font-size: 16px;
        }

        .success-alert {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 18px 24px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
        }

        .success-alert i {
            font-size: 20px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 26px;
        }

        .stat-icon.orange { background: #fed7aa; color: #f59e0b; }
        .stat-icon.blue { background: #dbeafe; color: #3b82f6; }
        .stat-icon.green { background: #d1fae5; color: #10b981; }
        .stat-icon.purple { background: #ede9fe; color: #8b5cf6; }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
        }

        /* Section */
        .section {
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
        }

        .section-title i {
            color: #f59e0b;
        }

        .see-all {
            color: #f59e0b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        /* Action Cards */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .action-card {
            background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
            padding: 28px;
            border-radius: 16px;
            border: 2px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover {
            border-color: #f59e0b;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.15);
        }

        .action-card-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .action-card-icon.orange { background: #fed7aa; color: #f59e0b; }
        .action-card-icon.blue { background: #dbeafe; color: #3b82f6; }

        .action-card h3 {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .action-card p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
        }

        .logout-btn {
            color: #ef4444;
        }

        .logout-btn:hover {
            background: #fee2e2;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-chalkboard-teacher"></i>
            <div>
                <div class="logo-text">May-IT</div>
                <div class="logo-subtitle">Espace Moniteur</div>
            </div>
        </div>

        <nav class="menu">
            <a href="index.php?page=moniteur" class="menu-item active">
                <i class="fas fa-chart-line"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="index.php?page=planning" class="menu-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Mon planning</span>
            </a>
            <a href="index.php?page=mes-eleves" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Mes élèves</span>
            </a>
            <a href="index.php?page=evaluations" class="menu-item">
                <i class="fas fa-clipboard-check"></i>
                <span>Évaluations</span>
            </a>
            <a href="index.php?page=profil-moniteur" class="menu-item">
                <i class="fas fa-user-circle"></i>
                <span>Mon profil</span>
            </a>
            <a href="index.php?page=logout" class="menu-item logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </a>
        </nav>

        <div class="user-section">
            <div class="user-avatar">
                <?= strtoupper(substr($moniteurActuel['prenom'], 0, 1) . substr($moniteurActuel['nom'], 0, 1)) ?>
            </div>
            <div class="user-info">
                <h4><?= htmlspecialchars($moniteurActuel['prenom'] . ' ' . $moniteurActuel['nom']) ?></h4>
                <p>Moniteur</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 class="greeting">
                Bonjour <?= htmlspecialchars($moniteurActuel['prenom']) ?> <span class="wave">👋</span>
            </h1>
            <p class="subtitle">Voici votre activité du jour</p>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-alert">
                <i class="fas fa-check-circle"></i>
                <span>Bienvenue ! Votre compte moniteur a été créé avec succès.</span>
            </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value"><?= $nbEleves ?></div>
        <div class="stat-label">Élèves actifs</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-value"><?= $nbLeconsAujourdhui ?></div>
        <div class="stat-label">Leçons aujourd'hui</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-value"><?= $heuresMois ?>h</div>
        <div class="stat-label">Heures ce mois</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-value">-</div>
        <div class="stat-label">Évaluation moyenne</div>
    </div>
</div>
        <!-- Planning du jour -->
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-calendar-day"></i>
                    Planning du jour
                </h2>
                <a href="index.php?page=planning" class="see-all">
                    Voir tout <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>Aucune leçon prévue aujourd'hui</p>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="action-grid">
            <a href="index.php?page=planning" class="action-card">
                <div class="action-card-icon orange">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h3>Gérer mon planning</h3>
                <p>Planifier des leçons de conduite</p>
            </a>

            <a href="index.php?page=mes-eleves" class="action-card">
                <div class="action-card-icon blue">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3>Voir mes élèves</h3>
                <p>Consulter la liste de vos élèves</p>
            </a>
        </div>
    </div>
</body>
</html>