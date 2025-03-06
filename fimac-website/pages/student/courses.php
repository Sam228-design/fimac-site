<?php
session_start();
require_once '../../auth/auth.php';
require_once '../../config/database.php';

$auth = new Auth();
$auth->requireStudent();

$user = $auth->getCurrentUser();
$conn = getConnection();

// Récupérer tous les cours disponibles pour la filière et le niveau de l'étudiant
$stmt = $conn->prepare("
    SELECT c.*, 
           u.first_name as teacher_first_name, 
           u.last_name as teacher_last_name,
           CASE WHEN ce.id IS NOT NULL THEN true ELSE false END as is_enrolled,
           ce.status as enrollment_status
    FROM courses c
    JOIN users u ON c.teacher_id = u.id
    LEFT JOIN course_enrollments ce ON c.id = ce.course_id AND ce.student_id = ?
    WHERE c.filiere = ? 
    AND c.niveau = ?
    AND c.published = 1
    ORDER BY c.created_at DESC
");

$stmt->execute([$user['id'], $user['filiere'], $user['niveau']]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les cours auxquels l'étudiant est inscrit
$stmt = $conn->prepare("
    SELECT c.*, 
           u.first_name as teacher_first_name, 
           u.last_name as teacher_last_name,
           ce.status as enrollment_status,
           (
               SELECT COUNT(*) 
               FROM assignments a 
               WHERE a.course_id = c.id 
               AND a.due_date > NOW()
           ) as pending_assignments
    FROM course_enrollments ce
    JOIN courses c ON ce.course_id = c.id
    JOIN users u ON c.teacher_id = u.id
    WHERE ce.student_id = ?
    ORDER BY ce.enrollment_date DESC
");

$stmt->execute([$user['id']]);
$enrolled_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cours - FIMAC</title>
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
                        <a class="nav-link" href="dashboard.php">
                            <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="courses.php">
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
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Mes cours -->
        <section class="mb-5">
            <h2 class="mb-4">Mes cours</h2>
            <?php if (empty($enrolled_courses)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Vous n'êtes inscrit(e) à aucun cours pour le moment.
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($enrolled_courses as $course): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <?php if ($course['image_path']): ?>
                                    <img src="<?php echo htmlspecialchars($course['image_path']); ?>" 
                                         class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                    <p class="card-text">
                                        <?php echo htmlspecialchars(substr($course['description'], 0, 100)) . '...'; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge bg-primary">
                                            <?php echo htmlspecialchars($course['filiere']); ?>
                                        </span>
                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($course['niveau']); ?>
                                        </span>
                                    </div>
                                    <div class="text-muted mb-3">
                                        <small>
                                            <i class="fas fa-chalkboard-teacher me-2"></i>
                                            <?php echo htmlspecialchars($course['teacher_first_name'] . ' ' . $course['teacher_last_name']); ?>
                                        </small>
                                    </div>
                                    <?php if ($course['pending_assignments'] > 0): ?>
                                        <div class="alert alert-warning py-2 mb-3">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <?php echo $course['pending_assignments']; ?> devoir(s) en attente
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-grid">
                                        <a href="view_course.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-primary">
                                            <i class="fas fa-eye me-2"></i>Accéder au cours
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Cours disponibles -->
        <section>
            <h2 class="mb-4">Cours disponibles</h2>
            <div class="row g-4">
                <?php foreach ($courses as $course): ?>
                    <?php if (!$course['is_enrolled']): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <?php if ($course['image_path']): ?>
                                    <img src="<?php echo htmlspecialchars($course['image_path']); ?>" 
                                         class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                    <p class="card-text">
                                        <?php echo htmlspecialchars(substr($course['description'], 0, 100)) . '...'; ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge bg-primary">
                                            <?php echo htmlspecialchars($course['filiere']); ?>
                                        </span>
                                        <span class="badge bg-secondary">
                                            <?php echo htmlspecialchars($course['niveau']); ?>
                                        </span>
                                    </div>
                                    <div class="text-muted mb-3">
                                        <small>
                                            <i class="fas fa-chalkboard-teacher me-2"></i>
                                            <?php echo htmlspecialchars($course['teacher_first_name'] . ' ' . $course['teacher_last_name']); ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-grid gap-2">
                                        <a href="view_course.php?id=<?php echo $course['id']; ?>" 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-eye me-2"></i>Aperçu du cours
                                        </a>
                                        <form action="enroll_course.php" method="POST">
                                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-sign-in-alt me-2"></i>S'inscrire
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (!array_filter($courses, function($course) { return !$course['is_enrolled']; })): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Aucun nouveau cours disponible pour le moment.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
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
