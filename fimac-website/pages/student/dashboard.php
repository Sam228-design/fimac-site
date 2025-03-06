<?php
session_start();
require_once '../../auth/auth.php';

$auth = new Auth();
$auth->requireStudent();

$user = $auth->getCurrentUser();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - FIMAC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">
                <i class="fas fa-graduation-cap me-2"></i>FIMAC
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="courses.php">
                            <i class="fas fa-book me-2"></i>Mes cours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assignments.php">
                            <i class="fas fa-tasks me-2"></i>Devoirs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="grades.php">
                            <i class="fas fa-chart-line me-2"></i>Notes
                        </a>
                    </li>
                </ul>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user-circle me-2"></i>Mon profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i>Paramètres
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="../../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Welcome Section -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h3">Bienvenue, <?php echo htmlspecialchars($user['first_name']); ?> !</h1>
                    <p class="text-muted">
                        <?php echo htmlspecialchars($user['filiere'] . ' - ' . $user['niveau']); ?>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">
                        <i class="fas fa-calendar me-2"></i>
                        <?php echo date('d/m/Y'); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row dashboard-stats">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-book"></i>
                    <h3>12</h3>
                    <p>Cours en cours</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-tasks"></i>
                    <h3>5</h3>
                    <p>Devoirs à rendre</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-chart-line"></i>
                    <h3>85%</h3>
                    <p>Moyenne générale</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-calendar-check"></i>
                    <h3>95%</h3>
                    <p>Assiduité</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <!-- Upcoming Assignments -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tasks me-2 text-primary"></i>Devoirs à venir
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cours</th>
                                        <th>Devoir</th>
                                        <th>Date limite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Algorithmique</td>
                                        <td>TP Tri fusion</td>
                                        <td>10/03/2025</td>
                                    </tr>
                                    <tr>
                                        <td>Base de données</td>
                                        <td>Projet SQL</td>
                                        <td>15/03/2025</td>
                                    </tr>
                                    <tr>
                                        <td>Réseaux</td>
                                        <td>Configuration TCP/IP</td>
                                        <td>20/03/2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Grades -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>Notes récentes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cours</th>
                                        <th>Évaluation</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Java</td>
                                        <td>Contrôle POO</td>
                                        <td>18/20</td>
                                    </tr>
                                    <tr>
                                        <td>Web</td>
                                        <td>Projet PHP</td>
                                        <td>16/20</td>
                                    </tr>
                                    <tr>
                                        <td>Systèmes</td>
                                        <td>TP Linux</td>
                                        <td>15/20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell me-2 text-primary"></i>Notifications
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="notification info">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <strong>Nouveau cours disponible</strong>
                                <p class="mb-0">Le cours "Introduction à Python" est maintenant disponible.</p>
                            </div>
                        </div>
                        <div class="notification warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Rappel</strong>
                                <p class="mb-0">N'oubliez pas de rendre le TP d'Algorithmique avant le 10/03/2025.</p>
                            </div>
                        </div>
                        <div class="notification success">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Note publiée</strong>
                                <p class="mb-0">Votre note pour le contrôle de POO a été publiée.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-graduation-cap me-2"></i>FIMAC</h5>
                    <p>Formation professionnelle de qualité depuis plus de 20 ans.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; <?php echo date('Y'); ?> FIMAC. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
</body>
</html>
