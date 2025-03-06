<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $auth = new Auth();
    $result = $auth->login($email, $password);

    if ($result['success']) {
        // Gérer "Se souvenir de moi"
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            if ($auth->storeRememberToken($_SESSION['user_id'], $token)) {
                setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 jours
            }
        }

        // Redirection en fonction du type d'utilisateur
        $redirectPath = '../pages/';
        switch ($_SESSION['user_type']) {
            case 'student':
                $redirectPath .= 'student/dashboard.php';
                break;
            case 'teacher':
                $redirectPath .= 'teacher/dashboard.php';
                break;
            case 'admin':
                $redirectPath .= 'admin/dashboard.php';
                break;
            default:
                $redirectPath = '../index.php';
        }

        $_SESSION['success'] = "Connexion réussie ! Bienvenue " . $_SESSION['user_name'];
        header("Location: $redirectPath");
        exit();
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>
