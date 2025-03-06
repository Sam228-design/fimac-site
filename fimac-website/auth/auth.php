<?php
session_start();
require_once '../config/database.php';

class Auth {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function register($data) {
        try {
            // Validation des données
            if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email']) || 
                empty($data['password']) || empty($data['gender']) || empty($data['birthDate']) || 
                empty($data['birthPlace']) || empty($data['filiere']) || empty($data['niveau'])) {
                return ["success" => false, "message" => "Tous les champs sont obligatoires"];
            }

            // Validation de l'email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return ["success" => false, "message" => "Format d'email invalide"];
            }

            // Vérifier si l'email existe déjà
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$data['email']]);
            if ($stmt->fetch()) {
                return ["success" => false, "message" => "Cet email est déjà utilisé"];
            }

            // Hash du mot de passe
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insertion de l'utilisateur
            $stmt = $this->conn->prepare("
                INSERT INTO users (
                    first_name, last_name, email, password, 
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

            $stmt->execute([
                $data['firstName'],
                $data['lastName'],
                $data['email'],
                $hashedPassword,
                $data['gender'],
                $data['birthDate'],
                $data['birthPlace'],
                $data['role'],
                $data['filiere'],
                $data['niveau']
            ]);

            return ["success" => true, "message" => "Inscription réussie ! Vous pouvez maintenant vous connecter."];
        } catch(PDOException $e) {
            error_log("Erreur d'inscription : " . $e->getMessage());
            return ["success" => false, "message" => "Une erreur est survenue lors de l'inscription"];
        }
    }

    public function login($email, $password) {
        try {
            // Validation des données
            if (empty($email) || empty($password)) {
                return ["success" => false, "message" => "Veuillez remplir tous les champs"];
            }

            // Validation de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ["success" => false, "message" => "Format d'email invalide"];
            }

            // Récupération de l'utilisateur
            $stmt = $this->conn->prepare("
                SELECT id, first_name, last_name, email, password, role, 
                       gender, date_of_birth, birth_place, filiere, niveau 
                FROM users WHERE email = ?
            ");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return ["success" => false, "message" => "Email ou mot de passe incorrect"];
            }

            // Vérification du mot de passe
            if (!password_verify($password, $user['password'])) {
                return ["success" => false, "message" => "Email ou mot de passe incorrect"];
            }

            // Création de la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['filiere'] = $user['filiere'];
            $_SESSION['niveau'] = $user['niveau'];

            return [
                "success" => true,
                "role" => $user['role'],
                "message" => "Connexion réussie"
            ];
        } catch(PDOException $e) {
            error_log("Erreur de connexion : " . $e->getMessage());
            return ["success" => false, "message" => "Une erreur est survenue lors de la connexion"];
        }
    }

    public function logout() {
        // Destruction de toutes les variables de session
        $_SESSION = array();

        // Destruction du cookie de session
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }

        // Destruction de la session
        session_destroy();

        return ["success" => true, "message" => "Déconnexion réussie"];
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }

        try {
            $stmt = $this->conn->prepare("
                SELECT id, first_name, last_name, email, role, gender, 
                       date_of_birth, birth_place, filiere, niveau, created_at 
                FROM users WHERE id = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return null;
        }
    }

    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            $_SESSION['error'] = "Veuillez vous connecter pour accéder à cette page";
            header('Location: /fimac-website/auth/login.php');
            exit();
        }
    }

    public function requireTeacher() {
        $this->requireAuth();
        if ($_SESSION['role'] !== 'teacher') {
            $_SESSION['error'] = "Accès réservé aux professeurs";
            header('Location: /fimac-website/index.php');
            exit();
        }
    }

    public function requireStudent() {
        $this->requireAuth();
        if ($_SESSION['role'] !== 'student') {
            $_SESSION['error'] = "Accès réservé aux étudiants";
            header('Location: /fimac-website/index.php');
            exit();
        }
    }

    public function storeRememberToken($userId, $token) {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
            return $stmt->execute([$token, $userId]);
        } catch(PDOException $e) {
            error_log("Erreur lors du stockage du token : " . $e->getMessage());
            return false;
        }
    }
}
?>
