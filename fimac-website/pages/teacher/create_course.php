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
    <title>Créer un Cours - FIMAC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <!-- Ajout de l'éditeur TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
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
                        <a class="nav-link" href="students.php">
                            <i class="fas fa-users me-2"></i>Étudiants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assignments.php">
                            <i class="fas fa-tasks me-2"></i>Devoirs
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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="h3 mb-4">Créer un nouveau cours</h1>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="process_create_course.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Titre du cours</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="filiere" class="form-label">Filière</label>
                                    <select class="form-select" id="filiere" name="filiere" required>
                                        <option value="">Choisir...</option>
                                        <option value="MIR">Maintenance Informatique (MIR)</option>
                                        <option value="DA">Développement d'Applications (DA)</option>
                                        <option value="ELT">Électrotechnique (ELT)</option>
                                        <option value="TLC">Télécommunications (TLC)</option>
                                        <option value="CGE">Comptabilité et Gestion (CGE)</option>
                                        <option value="AC">Action Commerciale (AC)</option>
                                        <option value="AG">Administration et Gestion (AG)</option>
                                        <option value="CCA">Contrôle d'Audit (CCA)</option>
                                        <option value="TLT">Transport et Logistique (TLT)</option>
                                        <option value="SD">Science des Données (SD)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="niveau" class="form-label">Niveau</label>
                                    <select class="form-select" id="niveau" name="niveau" required>
                                        <option value="">Choisir...</option>
                                        <option value="BT1">BT1</option>
                                        <option value="BT2">BT2</option>
                                        <option value="BT3">BT3</option>
                                        <option value="BTS1">BTS1</option>
                                        <option value="BTS2">BTS2</option>
                                        <option value="LICENCE1">LICENCE1</option>
                                        <option value="LICENCE2">LICENCE2</option>
                                        <option value="LICENCE3">LICENCE3</option>
                                        <option value="MASTER">MASTER</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description courte</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                <div class="form-text">Une brève description qui apparaîtra dans la liste des cours</div>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenu du cours</label>
                                <textarea class="form-control" id="content" name="content" rows="10"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Image du cours (optionnel)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div class="form-text">Format recommandé : 16:9, taille maximale : 2MB</div>
                            </div>

                            <div class="mb-3">
                                <label for="materials" class="form-label">Documents du cours (optionnel)</label>
                                <input type="file" class="form-control" id="materials" name="materials[]" multiple>
                                <div class="form-text">Formats acceptés : PDF, DOC, DOCX, PPT, PPTX. Taille maximale : 10MB par fichier</div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="published" name="published" checked>
                                    <label class="form-check-label" for="published">
                                        Publier le cours immédiatement
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="courses.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Créer le cours
                                </button>
                            </div>
                        </form>
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
