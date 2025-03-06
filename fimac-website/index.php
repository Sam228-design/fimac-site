<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIMAC - Formation en Informatique, Management et Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <base href="/fimac-website/">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <span class="fw-bold">FIMAC</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#accueil">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#formations">Formations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="auth/login.php" class="btn btn-primary">Connexion</a>
                    <a href="auth/register.php" class="btn btn-light">
                        <i class="fas fa-user-plus me-2"></i>Inscription
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="hero-section text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Bienvenue à FIMAC</h1>
                    <p class="lead mb-4">Formation professionnelle en informatique, management et commerce. Préparez votre avenir avec nos programmes adaptés au marché du travail.</p>
                    <h1 class="slogan">FIMAC École des Leaders de Demain !</h1>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="auth/register.php" class="btn btn-primary btn-lg px-4 me-md-2">
                            <i class="fas fa-rocket me-2"></i>S'inscrire maintenant
                        </a>
                        <a href="#formations" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-book me-2"></i>Nos formations
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="media/logos/logo-fimac.png" alt="FIMAC Campus" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Formations Section -->
    <section id="formations" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nos Formations</h2>
            <div class="row g-4">
                <!-- Informatique -->
                <div class="col-md-4">
                    <div class="card h-100 formation-card">
                        <div class="card-body">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h5 class="card-title">Informatique</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Maintenance Informatique (MIR)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Développement d'Applications (DA)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Électrotechnique (ELT)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Télécommunications (TLC)</li>
                            </ul>
                            <a href="formations/informatique.php" class="btn btn-primary mt-3">
                                <i class="fas fa-info-circle me-2"></i>En savoir plus
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Management -->
                <div class="col-md-4">
                    <div class="card h-100 formation-card">
                        <div class="card-body">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h5 class="card-title">Management</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Comptabilité et Gestion (CGE)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Action Commerciale (AC)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Administration et Gestion (AG)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Contrôle d'Audit (CCA)</li>
                            </ul>
                            <a href="formations/management.php" class="btn btn-primary mt-3">
                                <i class="fas fa-info-circle me-2"></i>En savoir plus
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Commerce -->
                <div class="col-md-4">
                    <div class="card h-100 formation-card">
                        <div class="card-body">
                            <div class="icon-wrapper mb-3">
                                <i class="fas fa-store"></i>
                            </div>
                            <h5 class="card-title">Commerce</h5>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Transport et Logistique (TLT)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sécrétariat de Direction (SD)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Marketing Digital</li>
                                <li><i class="fas fa-check text-success me-2"></i>Commerce International</li>
                            </ul>
                            <a href="formations/commerce.php" class="btn btn-primary mt-3">
                                <i class="fas fa-info-circle me-2"></i>En savoir plus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">À propos de FIMAC</h2>
                    <p class="lead">FIMAC est un établissement d'enseignement supérieur spécialisé dans la formation professionnelle.</p>
                    <div class="features">
                        <div class="feature-item">
                            <i class="fas fa-history text-primary"></i>
                            <span>Plus de 20 ans d'expérience</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chalkboard-teacher text-primary"></i>
                            <span>Des formateurs experts</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-graduation-cap text-primary"></i>
                            <span>Programmes adaptés au marché</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-users text-primary"></i>
                            <span>Accompagnement personnalisé</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="/fimac-website/media/images/campus-fimac.jpg" alt="Campus FIMAC" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Contactez-nous</h2>
            <div class="row">
                <div class="col-lg-6">
                    <form id="contactForm" action="process_contact.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Informations de contact</h5>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <strong>Adresse:</strong><br>
                                        Rue Adidoadin, Fin pavé derrière l'hotel la concorde<br>
                                        Lmoé, Togo
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <div>
                                        <strong>Téléphone:</strong><br>
                                        +228 96 14 26 96
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <div>
                                        <strong>Email:</strong><br>
                                        ecolefimac@gmail.com
                                    </div>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <strong>Horaires d'ouverture:</strong><br>
                                        Lundi - Vendredi: 8h00 - 18h00<br>
                                        Samedi: 9h00 - 13h00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-graduation-cap me-2"></i>FIMAC</h5>
                    <p>Formation professionnelle de qualité depuis plus de 20 ans.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#accueil"><i class="fas fa-home me-2"></i>Accueil</a></li>
                        <li><a href="#formations"><i class="fas fa-book me-2"></i>Formations</a></li>
                        <li><a href="#about"><i class="fas fa-info-circle me-2"></i>À propos</a></li>
                        <li><a href="#contact"><i class="fas fa-envelope me-2"></i>Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Suivez-nous</h5>
                    <div class="social-links">
                        <a href="#" class="me-2"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> FIMAC. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
