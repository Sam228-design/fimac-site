<?php
session_start();
require_once '../../auth/auth.php';

$auth = new Auth();
$auth->requireTeacher();

$user = $auth->getCurrentUser();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Professeur - FIMAC</title>
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
                        <a class="nav-link" href="students.php">
                            <i class="fas fa-users me-2"></i>Étudiants
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
                    <h1 class="h3">Bienvenue, Prof. <?php echo htmlspecialchars($user['last_name']); ?> !</h1>
                    <p class="text-muted">Tableau de bord professeur</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">
                        <i class="fas fa-calendar me-2"></i>
                        <?php echo date('d/m/Y'); ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Actions rapides</h5>
                        <div class="d-flex gap-2">
                            <a href="create_course.php" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nouveau cours
                            </a>
                            <a href="create_assignment.php" class="btn btn-success">
                                <i class="fas fa-tasks me-2"></i>Nouveau devoir
                            </a>
                            <a href="grade_assignments.php" class="btn btn-info">
                                <i class="fas fa-check me-2"></i>Noter les devoirs
                            </a>
                            <a href="send_notification.php" class="btn btn-warning">
                                <i class="fas fa-bell me-2"></i>Envoyer une notification
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row dashboard-stats">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-book"></i>
                    <h3>8</h3>
                    <p>Cours actifs</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-users"></i>
                    <h3>156</h3>
                    <p>Étudiants</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-tasks"></i>
                    <h3>12</h3>
                    <p>Devoirs à noter</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-comments"></i>
                    <h3>25</h3>
                    <p>Messages non lus</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <!-- Recent Submissions -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-alt me-2 text-primary"></i>Soumissions récentes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Devoir</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jean Dupont</td>
                                        <td>TP Java</td>
                                        <td>03/03/2025</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Marie Martin</td>
                                        <td>Projet Web</td>
                                        <td>02/03/2025</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Paul Bernard</td>
                                        <td>TP Réseaux</td>
                                        <td>01/03/2025</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Performance -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>Performance des étudiants
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cours</th>
                                        <th>Moyenne</th>
                                        <th>Taux de réussite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Algorithmique</td>
                                        <td>15.5/20</td>
                                        <td>85%</td>
                                    </tr>
                                    <tr>
                                        <td>Base de données</td>
                                        <td>14.8/20</td>
                                        <td>80%</td>
                                    </tr>
                                    <tr>
                                        <td>Programmation Web</td>
                                        <td>16.2/20</td>
                                        <td>90%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Classes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar me-2 text-primary"></i>Cours à venir
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cours</th>
                                        <th>Filière</th>
                                        <th>Niveau</th>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Salle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Programmation Java</td>
                                        <td>MIR</td>
                                        <td>BTS2</td>
                                        <td>05/03/2025</td>
                                        <td>08:00 - 10:00</td>
                                        <td>Lab 101</td>
                                    </tr>
                                    <tr>
                                        <td>Base de données</td>
                                        <td>DA</td>
                                        <td>BTS1</td>
                                        <td>05/03/2025</td>
                                        <td>10:15 - 12:15</td>
                                        <td>Lab 102</td>
                                    </tr>
                                    <tr>
                                        <td>Réseaux</td>
                                        <td>TLC</td>
                                        <td>BTS2</td>
                                        <td>05/03/2025</td>
                                        <td>14:00 - 16:00</td>
                                        <td>Lab 103</td>
                                    </tr>
                                </tbody>
                            </table>
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
