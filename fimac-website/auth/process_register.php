<?php
session_start();
require_once 'auth.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des données
    $requiredFields = [
        'firstName', 'lastName', 'email', 'password', 'confirmPassword',
        'gender', 'birthDate', 'birthPlace', 'filiere', 'niveau', 'terms', 'role'
    ];

    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs obligatoires";
        header('Location: register.php');
        exit();
    }

    // Validation du mot de passe
    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas";
        header('Location: register.php');
        exit();
    }

    if (strlen($_POST['password']) < 8) {
        $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères";
        header('Location: register.php');
        exit();
    }

    // Validation de l'email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format d'email invalide";
        header('Location: register.php');
        exit();
    }

    // Validation de la date de naissance
    $birthDate = new DateTime($_POST['birthDate']);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 15) {
        $_SESSION['error'] = "Vous devez avoir au moins 15 ans pour vous inscrire";
        header('Location: register.php');
        exit();
    }

    try {
        $conn = getConnection();

        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$_POST['email']]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Cette adresse email est déjà utilisée";
            header('Location: register.php');
            exit();
        }

        // Validation du rôle
        $role = $_POST['role'];
        if (!in_array($role, ['student', 'teacher'])) {
            $_SESSION['error'] = "Type de compte invalide";
            header('Location: register.php');
            exit();
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insertion de l'utilisateur
        $stmt = $conn->prepare("
            INSERT INTO users (
                email, password, first_name, last_name,
                gender, date_of_birth, birth_place,
                role, filiere, niveau,
                created_at, updated_at
            ) VALUES (
                ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                NOW(), NOW()
            )
        ");

        if ($stmt->execute([
            $_POST['email'],
            $hashedPassword,
            htmlspecialchars($_POST['firstName']),
            htmlspecialchars($_POST['lastName']),
            $_POST['gender'],
            $_POST['birthDate'],
            htmlspecialchars($_POST['birthPlace']),
            $role,
            $_POST['filiere'],
            $_POST['niveau']
        ])) {
            sendNotification('Nouvelle inscription', 'Un nouvel utilisateur s est inscrit avec l email : ' . $_POST['email']);
            $_SESSION['success'] = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
            header('Location: login.php');
            exit();
        }

    } catch (PDOException $e) {
        error_log("Erreur d'inscription : " . $e->getMessage());
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        header('Location: register.php');
        exit();
    }
} else {
    header('Location: register.php');
    exit();
}
?>
