<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - FIMAC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">
                                <i class="fas fa-graduation-cap text-primary me-2"></i>FIMAC
                            </h2>
                            <p class="text-muted">Créez votre compte</p>
                        </div>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="process_register.php" method="POST" id="registerForm">
                            <!-- Type de compte -->
                            <h5 class="mb-3">Type de compte</h5>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">Choisir...</option>
                                        <option value="student">Étudiant</option>
                                        <option value="teacher">Professeur</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Informations personnelles -->
                            <h5 class="mb-3 mt-4">Informations personnelles</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">Prénom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Nom</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Genre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="">Choisir...</option>
                                            <option value="M">Masculin</option>
                                            <option value="F">Féminin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birthDate" class="form-label">Date de naissance</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" id="birthDate" name="birthDate" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="birthPlace" class="form-label">Lieu de naissance</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" id="birthPlace" name="birthPlace" required>
                                </div>
                            </div>

                            <!-- Informations académiques -->
                            <h5 class="mb-3 mt-4">Informations académiques</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="filiere" class="form-label">Filière</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
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
                                            <option value="SD">Sécretaria de Direcion(SD)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="niveau" class="form-label">Niveau</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
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
                            </div>

                            <!-- Informations de connexion -->
                            <h5 class="mb-3 mt-4">Informations de connexion</h5>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Conditions d'utilisation -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">conditions d'utilisation</a>
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Créer mon compte
                                </button>
                                <a href="login.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Déjà inscrit ? Connectez-vous
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal des conditions d'utilisation -->
    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conditions d'utilisation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Acceptation des conditions</h6>
                    <p>En créant un compte sur la plateforme FIMAC, vous acceptez d'être lié par les présentes conditions d'utilisation.</p>

                    <h6>2. Utilisation du compte</h6>
                    <p>Vous êtes responsable de maintenir la confidentialité de votre compte et de votre mot de passe.</p>

                    <h6>3. Contenu</h6>
                    <p>Vous acceptez de ne pas publier de contenu illégal, offensant ou inapproprié sur la plateforme.</p>

                    <h6>4. Protection des données</h6>
                    <p>Vos données personnelles seront traitées conformément à notre politique de confidentialité.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const password = document.getElementById('confirmPassword');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
